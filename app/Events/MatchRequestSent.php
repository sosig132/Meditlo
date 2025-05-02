<?php

namespace App\Events;

use App\Models\MatchRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchRequestSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $matchRequest;
    /**
     * Create a new event instance.
     */
    public function __construct(MatchRequest $matchRequest)
    {
        $this->matchRequest = $matchRequest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [new Channel('user.' . $this->matchRequest->receiver_id)];
    }

    /**
     * Customize the name of the event broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'match-request-sent';
    }
    public function broadcastWith()
    {
        return [
            'sender_id' => $this->matchRequest->sender_id,
            'receiver_id' => $this->matchRequest->receiver_id,
            'status' => $this->matchRequest->status,
            'message' => "New match request from user {$this->matchRequest->sender_id}.",
        ];
    }
}
