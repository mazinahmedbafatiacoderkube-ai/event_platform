<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use App\Events\MessageSent;
use App\Models\Message;

class ChatService
{
    public function __construct(private MessageRepository $messageRepo) {}

    public function sendMessage($eventId, $user = null, $messageText)
    {
        // Check if logged-in user
        if ($user) {
            // Organization/staff message
            $message = Message::create([
                'event_id' => $eventId,
                'user_id' => $user->id,
                'attendee_name' => null,   // Ensure attendee_name is null
                'attendee_email' => null,
                'message' => $messageText,
            ]);
        } else {
            // Attendee message
            $message = Message::create([
                'event_id' => $eventId,
                'user_id' => null,          // Ensure user_id is null
                'attendee_name' => request('name'),
                'attendee_email' => request('email'),
                'message' => $messageText,
            ]);
        }

        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    public function getMessages($eventId)
    {
        return Message::where('event_id', $eventId)
            ->with('user')
            ->latest()
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,

                    'sender_id' => $msg->user_id,
                    'sender_type' => $msg->user_id ? 'user' : 'attendee',

                    'sender_name' => $msg->user
                        ? $msg->user->name
                        : $msg->attendee_name,
                ];
            });
    }
}
