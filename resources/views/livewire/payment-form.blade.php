<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="text-center mb-6">
                <h2 class="font-bold text-lg mb-4 text-gray-100">Complete Payment</h2>
                <p class="text-gray-300">Register for: {{ $session->title }}</p>
            </div>

            <div class="bg-gray-700 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-100 mb-2">Session Details</h3>
                <p class="text-gray-300"><strong>Date:</strong> {{ $session->start_time->format('F j, Y') }}</p>
                <p class="text-gray-300"><strong>Time:</strong> {{ $session->start_time->format('g:i a') }} - {{ $session->end_time->format('g:i a') }}</p>
                <p class="text-gray-300"><strong>Price:</strong> ${{ number_format($session->price, 2) }}</p>
                @if($session->description)
                    <p class="text-gray-300 mt-2"><strong>Description:</strong> {{ $session->description }}</p>
                @endif
            </div>

            @if(session('error'))
                <div class="bg-red-900/20 border border-red-600 rounded-lg p-4 mb-6">
                    <p class="text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            <div id="payment-status-message" class="hidden text-center p-4 rounded-lg mb-6"></div>

            <form id="payment-form" class="space-y-4">
                @csrf
                <input type="hidden" name="payment_intent_id" value="{{ $paymentIntentId }}">
                
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Payment Information</span>
                    </label>
                    <div id="payment-element" class="bg-gray-700 rounded-lg p-4">
                    </div>
                </div>

                <div id="payment-message" class="hidden text-center p-4 rounded-lg"></div>
                
                <div class="flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-300 text-sm">
                        Cancel and return to dashboard
                    </a>
                    <button type="submit" id="submit-button" class="btn btn-primary">
                        Pay ${{ number_format($session->price, 2) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    console.log('Script loaded');
    
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements({ clientSecret: "{{ $clientSecret }}" });
    
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    // Handle form submission with Stripe
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const statusMessage = document.getElementById('payment-status-message');
    
    console.log('Form element:', form);
    console.log('Submit button:', submitButton);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('Payment form submitted');
        
        // Disable button and show loading
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        
        try {
            const { error, paymentIntent } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: window.location.href,
                },
                redirect: 'if_required',
            });

            if (error) {
                console.log('Payment error:', error);
                showMessage(error.message, 'error');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Pay ${{ number_format($session->price, 2) }}';
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                console.log('Payment succeeded, processing registration...');
                showMessage('Payment successful! Processing registration...', 'success');
                
                // Call Livewire method to register the student
                @this.processPayment();
                
            } else {
                console.log('Payment status:', paymentIntent?.status);
                showMessage('Payment is being processed. Please wait...', 'warning');
                
                // Call Livewire method to check status
                @this.processPayment();
            }
        } catch (err) {
            console.error('Unexpected error:', err);
            showMessage('An unexpected error occurred. Please try again.', 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Pay ${{ number_format($session->price, 2) }}';
        }
    });

    function showMessage(message, type) {
        statusMessage.textContent = message;
        statusMessage.classList.remove('hidden');
        
        // Remove existing classes
        statusMessage.classList.remove('bg-green-900/20', 'border-green-600', 'text-green-300');
        statusMessage.classList.remove('bg-red-900/20', 'border-red-600', 'text-red-300');
        statusMessage.classList.remove('bg-yellow-900/20', 'border-yellow-600', 'text-yellow-300');
        
        // Add appropriate classes based on type
        if (type === 'success') {
            statusMessage.classList.add('bg-green-900/20', 'border', 'border-green-600', 'text-green-300');
        } else if (type === 'error') {
            statusMessage.classList.add('bg-red-900/20', 'border', 'border-red-600', 'text-red-300');
        } else if (type === 'warning') {
            statusMessage.classList.add('bg-yellow-900/20', 'border', 'border-yellow-600', 'text-yellow-300');
        }
    }

    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        console.log('Livewire initialized');
        Livewire.on('payment-success', () => {
            console.log('Payment successful!');
            showMessage('Registration successful! Redirecting to dashboard...', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
            }, 2000);
        });
        
        Livewire.on('payment-error', (event) => {
            console.log('Payment error:', event.message);
            showMessage(event.message, 'error');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Pay ${{ number_format($session->price, 2) }}';
        });
    });
</script> 