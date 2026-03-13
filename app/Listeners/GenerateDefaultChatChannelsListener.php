<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\ChatChannel;

class GenerateDefaultChatChannelsListener
{
    public function handle(EventCreated $event)
    {
        // Example: Create default channels for the event
        ChatChannel::create([
            'event_id' => $event->event->id,
            'name' => 'General Chat',
        ]);

        ChatChannel::create([
            'event_id' => $event->event->id,
            'name' => 'Q&A',
        ]);
    }
}