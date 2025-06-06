
<div class="modal-box">
    <h2 class="modal-title text-2xl mb-3">Register</h2>
    <hr class="my-3 border-t-1 border-gray-200 opacity-30">
    <x-form wire:submit.prevent="register">
        <x-input label="Name" wire:model.defer="name" />
        {{-- @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-input label="Email" wire:model.defer="email" />
        {{-- @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-input label="Password" type="password" wire:model.defer="password" />
        {{-- @error('password')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-input label="Confirm Password" type="password" wire:model.defer="password_confirmation" />
        
        <x-slot:actions>
            <button class="underline" type="button" onclick="forgot_password_modal.showModal()">Forgot your password?</button>
            <x-button label="Register" class="btn-primary" type="submit" spinner="login" />
        </x-slot:actions>
    </x-form>
    <livewire:auth.forgot-password />
</div>
