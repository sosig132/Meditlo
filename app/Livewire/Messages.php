<?php

namespace App\Livewire;

use Livewire\Component;

class Messages extends Component
{
    public $messages = [];
    public $showDrawer = false;
    public $messagesCount = 0;

    public function mount()
    {
        $this->showDrawer = false;
    }
    public function toggleDrawer()
    {
        $this->showDrawer = !$this->showDrawer;
    }
    public function render()
    {
        return view('livewire.messages');
    }
}
