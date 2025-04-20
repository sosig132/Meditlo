<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MatchRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $show = false;
    public $notificationCount = 0;

    public function mount()
    {
        $this->show = false;
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()->notifications->where('read_at', null)->sortByDesc('created_at');
        $this->notificationCount = count($this->notifications);
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
