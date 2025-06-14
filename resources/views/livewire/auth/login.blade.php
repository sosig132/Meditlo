<dialog id="login_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box bg-gray-800 text-gray-100">
        <h2 class="font-bold text-lg mb-4">Login</h2>
        <x-form wire:submit.prevent="login">
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text text-gray-300">Email</span>
                </label>
                <input type="email" wire:model="email" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text text-gray-300">Password</span>
                </label>
                <input type="password" wire:model="password" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your password">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <x-slot:actions>
                <x-button onclick="login_modal.close()" label="Cancel" class="btn-ghost" />
                <x-button label="Login" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</dialog>
