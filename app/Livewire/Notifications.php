<?php

namespace App\Livewire;

use App\Events\MatchRequestSent;
use Livewire\Component;
use App\Models\MatchRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MatchRequestNotification;

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
                'status' => $notification->status,
            ];
        })->toArray();
        // show only the message
        $this->notificationCount = count($this->notifications);
    }

    public function acceptRequest($notificationId) {
        $notification = MatchRequest::find($notificationId);
        if ($notification) {
            $notification->markAsAccepted();
            $this->loadNotifications();
        }
        
        $user = Auth::user()->id;
        $userModel = new User();
        $user = $userModel->find($user);
        if ($user->isTutor()) {
            $user->addStudentToTutor($notification->sender_id);
        }
        else {
            $user = $userModel->find($notification->sender_id);
            $user->addStudentToTutor(Auth::user()->id);
        }
    }

    public function rejectRequest($notificationId) {
        $notification = MatchRequest::find($notificationId);
        if ($notification) {
            $notification->markAsRejected();
            $this->loadNotifications();
        }
    }

    public function sendMatchRequest($userId) {
      $user = Auth::user();
  
      $matchRequest = MatchRequest::create([
          'sender_id' => $user->id,
          'receiver_id' => $userId,
          'message' => "<a href=\"/profile/{$user->id}\">{$user->name}</a> would like to connect with you!",
      ]);
  
      event(new MatchRequestSent($matchRequest));
      $receiver = User::find($userId);
      $receiver->notify(new MatchRequestNotification($matchRequest));
      
      return response()->json(['message' => 'Match request sent successfully!']);
    }

    public function updateNotifications($matchRequest) {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
