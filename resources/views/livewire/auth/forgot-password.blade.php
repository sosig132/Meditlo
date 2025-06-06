<dialog id="forgot_password_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box">
        <h2 class="modal-title text-2xl mb-3">Password recovery</h2>
        <hr class="my-3 border-t-1 border-gray-200 opacity-30">
        <p class="mb-3">Please enter your email address and we will send you a link to reset your password.</p>
        <x-form wire:submit.prevent="sendPasswordRecoveryEmail">
            <x-input label="Email" wire:model="email" />
            <x-slot:actions>
                <x-button onclick="forgot_password_modal.close()" label="Cancel" />
                <x-button label="Submit" class="btn-primary" type="submit" spinner="sendPasswordRecoveryEmail" />
            </x-slot:actions>
        </x-form>
    </div>
</dialog>

@script
    <script>
        $wire.on('closeForgotPasswordModal', function() {
            forgot_password_modal.close();
        });
        $wire.on('showAlert', function(message) {
            setTimeout(() => {
            @this.showAlert(message);
        }, 500);
        });
    </script>
@endscript
