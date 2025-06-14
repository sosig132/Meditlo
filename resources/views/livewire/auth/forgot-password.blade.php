<dialog id="forgot_password_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box bg-gray-800 text-gray-100">
        <h2 class="font-bold text-lg mb-4">Password Recovery</h2>
        <p class="text-gray-300 mb-4">Please enter your email address and we will send you a link to reset your password.</p>
        <x-form wire:submit.prevent="sendPasswordRecoveryEmail">
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text text-gray-300">Email</span>
                </label>
                <input type="email" wire:model="email" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <x-slot:actions>
                <x-button onclick="forgot_password_modal.close()" label="Cancel" class="btn-ghost" />
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
