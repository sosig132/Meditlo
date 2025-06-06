<div class="align-middle full-height-no-navbar">
    <div class="modal-box mx-auto">
        <h2 class="modal-title text-2xl mb-3">Reset Password</h2>
        <hr class="my-3 border-t-1 border-gray-200 opacity-30">
        <x-form wire:submit.prevent="resetPassword">
            <x-input label="Password" type="password" wire:model="password" />
            <x-input label="Confirm Password" type="password" wire:model="password_confirmation" />
            <x-slot:actions>
                <x-button label="Reset Password" class="btn-primary" type="submit" spinner="resetPassword" />
            </x-slot:actions>
        </x-form>
    </div>
</div>

@script
<script>
    $wire.on('redirectToHome', function(message) {
        setTimeout(() => {
            window.location.href = '/';
        }, 5000);
    });
</script>
@endscript

