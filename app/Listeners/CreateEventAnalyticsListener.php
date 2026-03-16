<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\ChatChannel;

class CreateEventChatChannel
{
    public function handle(EventCreated $event)
    {
        $eventData = $event->event;

        ChatChannel::create([
            'event_id' => $eventData->id,
            'name' => $eventData->title . ' Chat',
        ]);
    }
}