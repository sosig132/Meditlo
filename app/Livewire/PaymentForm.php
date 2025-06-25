<?php

namespace App\Livewire;

use App\Models\TutorSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentForm extends Component
{
    public $sessionId;
    public $session;
    public $paymentIntentId;
    public $clientSecret;
    public $paymentStatus = 'pending';
    public $errorMessage = '';

    public function mount($sessionId)
    {
        $this->sessionId = $sessionId;
        $this->session = TutorSession::findOrFail($sessionId);
        
        // Check if user is a student
        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('error', 'Only students can register for sessions.');
        }

        // Check if session is full
        if (!$this->session->canAcceptMoreStudents()) {
            return redirect()->back()->with('error', 'This session is full.');
        }

        // Check if already registered
        if ($this->session->isStudentRegistered(Auth::id())) {
            return redirect()->back()->with('error', 'You are already registered for this session.');
        }

        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($this->session->price * 100), // Convert to cents
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'session_id' => $this->session->id,
                    'student_id' => Auth::id(),
                    'tutor_id' => $this->session->tutor_id,
                ],
            ]);

            // Store only the necessary data as simple properties
            $this->paymentIntentId = $paymentIntent->id;
            $this->clientSecret = $paymentIntent->client_secret;

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to initialize payment: ' . $e->getMessage());
        }
    }

    public function processPayment()
    {
        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($this->paymentIntentId);
            
            if ($paymentIntent->status === 'succeeded') {
                // Register student for session
                // check if he has a cancelled registration
                $existingParticipant = $this->session->participants()
                    ->where('student_id', Auth::id())
                    ->first();
                if ($existingParticipant) {
                    $existingParticipant->update(['status' => 'registered', 'payment_status' => 'paid', 'paid_at' => now(), 'stripe_payment_intent_id' => $paymentIntent->id]);
                } else {
                $this->session->participants()->create([
                    'student_id' => Auth::id(),
                    'status' => 'registered',
                    'payment_status' => 'paid',
                    'amount_paid' => $this->session->price,
                    'paid_at' => now(),
                    'stripe_payment_intent_id' => $paymentIntent->id,
                ]);
              }
                // Dispatch success event instead of redirecting
                $this->dispatch('payment-success');
                
            } else {
                // Dispatch error event
                $this->dispatch('payment-error', message: 'Payment status: ' . $paymentIntent->status);
            }

        } catch (\Exception $e) {
            // Dispatch error event
            $this->dispatch('payment-error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
} 