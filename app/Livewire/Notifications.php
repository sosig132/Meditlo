<?php

namespace App\Livewire;

use App\Events\MatchRequestSent;
use Livewire\Component;
use App\Models\MatchRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $show = false;
    public $notificationCount = 0;
    protected $listeners = ['matchRequestSent' => 'sendMatchRequest', 'updateNotifications'];

    public function mount()
    {
        $this->show = false;
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user_model = new User();
        $this->notifications = Auth::user()->matchRequests->where('read_at', null)->sortByDesc('created_at')->map(function ($notification) use ($user_model) {
            $sender = $user_model->find($notification->sender_id);
            return [
                'id' => $notification->id,
                'sender_name' => $sender ? $sender->name : 'Unknown',
                'message' => $notification->message,
                'created_at' => $notification->created_at,
            ];
        })->toArray();
        // show only the message
        $this->notificationCount = count($this->notifications);
    }

    public function sendMatchRequest($userId) {
        $user = Auth::user();

        // Create a new match request
        $matchRequest = MatchRequest::create([
            'sender_id' => $user->id,
            'receiver_id' => $userId,
            'message' => 'I would like to connect with you!',
        ]);

        // Optionally, trigger a notification or other logic
        event(new MatchRequestSent($matchRequest));
        return response()->json(['message' => 'Match request sent successfully!']);
    }

    public function updateNotifications($matchRequest) {
        $this->notifications[] = $matchRequest;
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
