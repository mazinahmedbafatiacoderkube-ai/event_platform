<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        // Eager load user if there is one
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('event.' . $this->message->event_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'message' => $this->message->message,

                'sender_id' => $this->message->user_id,
                'sender_type' => $this->message->user_id ? 'user' : 'attendee',

                'sender_name' => $this->message->user
                    ? $this->message->user->name
                    : $this->message->attendee_name,
            ]
        ];
    }
}
