<?php

namespace App\Notifications;

use App\Models\MatchRequest;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Auth;
class MatchRequestNotification extends Notification implements ShouldQueue
{
  use Queueable;
  protected $senderId;
  protected $senderName;
  public function __construct($senderId, $senderName){
    $this->senderId = $senderId;
    $this->senderName = $senderName;
  }

  public function via($notifiable)
  {
    return ['database', 'broadcast'];
  }

  public function toDatabase($notifiable)
  {
    return [
      'sender_id' => $this->senderId,
      'receiver_id' => $notifiable->id,
      'status' => 'pending',
      'message' => "New request from user <a href='/profile/{$this->senderId}'>{$this->senderName}!</a>",
    ];
  }
  public function toBroadcast($notifiable)
  {
    return new BroadcastMessage([
      'sender_id' => $this->senderId,
      'receiver_id' => $notifiable->id,
      'status' => 'pending',
      'message' => "New request from user <a href='/profile/{$this->senderId}'>{$this->senderName}!</a>",
    ]);
  }
}
