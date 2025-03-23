<div>
    <div class="border p-2 rounded">
        @foreach($options as $option)
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="selected" value="{{ $option }}" class="rounded border-gray-300">
                <span>{{ $option }}</span>
            </label>
        @endforeach
    </div>
</div>
