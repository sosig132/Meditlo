<div class="container mx-auto">
    <div class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 w-full flex-1">
        <x-input label="Name" wire:model="personName" />
        <div class="filters">
            <livewire:checkbox-select :options="$optionsSubjects" wire:model="selectedSubjects" />
            <livewire:checkbox-select :options="$optionsLevels" wire:model="selectedLevels" />
            <livewire:checkbox-select :options="$optionsStyles" wire:model="selectedStyles" />
        </div>
        <div class="flex justify-end">
            <button class="btn btn-primary" wire:click="filter">Filter</button>
        </div>
    </div>
</div>
