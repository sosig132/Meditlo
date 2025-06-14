<div class="modal-box bg-gray-800 text-gray-100">
    <h2 class="font-bold text-lg mb-4">Register</h2>
    <x-form wire:submit.prevent="register">
        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text text-gray-300">Name</span>
            </label>
            <input type="text" wire:model.defer="name" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your name">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text text-gray-300">Email</span>
            </label>
            <input type="email" wire:model.defer="email" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your email">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text text-gray-300">Password</span>
            </label>
            <input type="password" wire:model.defer="password" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter your password">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text text-gray-300">Confirm Password</span>
            </label>
            <input type="password" wire:model.defer="password_confirmation" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Confirm your password">
            @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <x-slot:actions>
            <button class="text-gray-300 hover:text-gray-100 underline" type="button" onclick="forgot_password_modal.showModal()">Forgot your password?</button>
            <x-button label="Register" class="btn-primary" type="submit" spinner="login" />
        </x-slot:actions>
    </x-form>
    <livewire:auth.forgot-password />
</div>
