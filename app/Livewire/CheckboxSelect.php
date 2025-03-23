<?php

namespace App\Livewire;

use Livewire\Component;

class CheckboxSelect extends Component
{
    public $selected = [];
    public $options = [];

    public function mount($options = [])
    {
        $this->options = $options;
    }

    public function updateSelected($value)
    {
        dd($this->selected);
        $this->emit('optionsUpdated', $this->getPropertyName(), $this->selected);
    }

    protected function getPropertyName() {
        dd("D");
        return str_replace('selectedOptions', '', $this->getName());
    }
    public function render()
    {
        return view('components.checkbox-select');
    }
}
