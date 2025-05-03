<?php

namespace App\Livewire;

use App\Events\MatchRequestSent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\MatchRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MatchRequestNotification;
class Notifications extends Component
{
  use LivewireAlert;
  public $notifications = [];
  public $show = false;
  public $notificationCount = 0;
  protected $listeners = ['matchRequestSent' => 'sendMatchRequest', 'openRequestModal' => 'openRequestModal','updateNotifications'];
  public $showRequestModal = false;
  public $currentRequestId = null;
  public function mount()
  {
    $this->show = false;
    $this->loadNotifications();
  }

  public function loadNotifications()
  {
    $this->notifications = Auth::user()->notifications
    ->sortByDesc('created_at')
    ->filter(function ($notification) {
      return !isset($notification->data['status']) || $notification->data['status'] === 'pending';
    })
    ->map(function ($notification) {
        $sender = User::find($notification->data['sender_id']);
        $type = '';
        if ($notification->type === 'App\Notifications\MatchRequestNotification') {
            $type = 'match_request';
        }
        return [
            'id' => $notification->id,
            'sender_name' => $sender ? $sender->name : 'Unknown',
            'message' => $notification->data['message'],
            'created_at' => $notification->created_at,
            'status' => $notification->data['status'],
            'type' => $type,
            'read' => $notification->read_at ? true : false,
        ];
    })->toArray();
    // show only the message
    $this->notificationCount = count(Auth::user()->unreadNotifications);
  }

  public function sendMatchRequest($userId)
  {
    $user = Auth::user();
    if (!$this->isEligibleToSendRequest($userId)) {
      $this->alertError('You cannot send a match request to this user.');
      $this->dispatch('close-modal');
      return;
    }

    $receiver = User::find($userId);
    $receiver->notify(new MatchRequestNotification($user->id, $user->name));

    return response()->json(['message' => 'Match request sent successfully!']);
  }

  public function isEligibleToSendRequest($receiverId)
{
    $user = Auth::user();

    if ($user->notifications()
            ->where('data->sender_id', $receiverId)
            ->exists()) {
        return false;
    }

    if ($user->isTutor()) {
        return $user->students()->where('student_id', $receiverId)->doesntExist();
    } else {
        return $user->tutors()->where('tutor_id', $receiverId)->doesntExist();
    }
}

  public function setAllNotificationsAsRead()
  {
    $user = Auth::user();
    $user->unreadNotifications->markAsRead();
    $this->notificationCount = 0;
    $this->loadNotifications();
  }

  public function updateNotifications()
  {
    $this->loadNotifications();
  }

  private function alertError($message){
    $this->alert('error', $message, [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
        
    ]);
  }
  private function alertSuccess($message){
    $this->alert('success', $message, [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);
}
  public function openRequestModal($id)
  {
      $this->currentRequestId = $id;
      $this->dispatch('show-request-modal');
  }
  
  public function closeRequestModal()
  {  
      $this->dispatch('close-request-modal');
  }
  
  public function acceptRequest()
  {
      $this->closeRequestModal();
      $notification = Auth::user()->notifications()
        ->where('id', $this->currentRequestId)
        ->first();

      if ($notification) {
          $notification->update(['data->status' => 'accepted']);
          $notification->markAsRead();
      }

      $user = Auth::user();
      if ($user->isTutor()) {
          
        User::addStudentToTutorStatic(
            $user->id,
            $notification->first()->data['sender_id']
          );
        } else {
          User::addStudentToTutorStatic(
            $notification->first()->data['sender_id'],
            $user->id
          );
        }
      $notification->first()->delete();
      $this->alertSuccess('Request accepted successfully! You are now connected with the user.');
      $this->loadNotifications();
  }
  
  public function rejectRequest()
  {
      $this->closeRequestModal();
      $notification = Auth::user()->notifications()
        ->where('id', $this->currentRequestId)
        ->first();
      if ($notification) {
          $notification->update(['data->status' => 'rejected']);
          $notification->markAsRead();
      }
      $notification->first()->delete();
      $this->loadNotifications();
  }
  public function render()
  {
    return view('livewire.notifications');
  }
}
