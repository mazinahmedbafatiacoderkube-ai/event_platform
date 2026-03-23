<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    public function getMessagesByEvent(int $eventId)
    {
        return Message::with('user')
            ->where('event_id', $eventId)
            ->latest()
            ->get();
    }

    public function createMessage(int $eventId, int $userId, string $message)
    {
        return Message::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'message' => $message
        ]);
    }
}