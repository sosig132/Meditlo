<?php

namespace App\Livewire;

use Livewire\Component;

class CheckboxSelect extends Component
{
    public $selected = [];
    public $options = [];
    public $type = null;

    public function mount($options = [], $type = "")
    {
        $this->options = $options;
        $this->type = $type;
    }

    public function updateSelected($value)
    {
        dd($this->selected);
        $this->emit('optionsUpdated', $this->getPropertyName(), $this->selected);
    }

    protected function getPropertyName() {
        return str_replace('selectedOptions', '', $this->getName());
    }
    public function render()
    {
        return view('components.checkbox-select');
    }
}
