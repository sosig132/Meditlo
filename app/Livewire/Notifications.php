<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];
    public $show = false;
    public $notificationCount = 0;

    public function mount()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
