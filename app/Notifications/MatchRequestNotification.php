<?php

namespace App\Notifications;

use App\Models\MatchRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class MatchRequestNotification extends Notification
{
    use Queueable;

    protected $matchRequest;

    public function __construct(MatchRequest $matchRequest)
    {
        $this->matchRequest = $matchRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->matchRequest->sender_id,
            'receiver_id' => $this->matchRequest->receiver_id,
            'status' => $this->matchRequest->status,
            'message' => "New request!",
        ];
    }
}
