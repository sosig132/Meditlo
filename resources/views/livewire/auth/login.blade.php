<dialog id="login_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box">
        <h2 class="modal-title text-2xl mb-3">Login</h2>
        <hr class="my-3 border-t-1 border-gray-200 opacity-30">
        <x-form wire:submit.prevent="login">
            <x-input label="Email" wire:model="email" />
            {{-- @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror --}}
            <x-input label="Password" type="password" wire:model="password" />
            {{-- @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror --}}
            <x-slot:actions>
                <x-button onclick="login_modal.close()" label="Cancel" />
                <x-button label="Login" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</dialog>
