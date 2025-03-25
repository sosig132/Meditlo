<div class="container mx-auto">
    <div class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 w-full flex-1">
        <x-input label="Name" wire:model="personName" />
        <div class="filters flex flex-row space-x-4 mt-4">
            <div class="w-1/5 bg-gray-800">
                <livewire:checkbox-select :options="$optionsSubjects" :type="'subjects'" wire:model="selectedSubjects" />
            </div>
            <div class="w-1/5 bg-gray-800">
                <livewire:checkbox-select :options="$optionsLevels" :type="'levels'" wire:model="selectedLevels" />
            </div>
            <div class="w-1/5 bg-gray-800">
                <livewire:checkbox-select :options="$optionsStyles" :type="'styles'" wire:model="selectedStyles" />
            </div>
        </div>
        <div class="flex justify-end">
            <button class="btn btn-primary" wire:click="filter">Filter</button>
        </div>
    </div>
</div>
