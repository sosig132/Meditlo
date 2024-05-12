
<div class="modal-box">
    <h2 class="modal-title text-2xl mb-3">Register</h2>
    <hr class="my-3 border-t-1 border-gray-200 opacity-30">
    <x-form wire:submit.prevent="register">
        <x-input label="Name" wire:model="name" />
        {{-- @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-input label="Email" wire:model="email" />
        {{-- @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-input label="Password" type="password" wire:model="password" />
        {{-- @error('password')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror --}}
        <x-slot:actions>
            <x-button label="Register" class="btn-primary" type="submit" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>
