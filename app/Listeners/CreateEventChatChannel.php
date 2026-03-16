<?php

namespace App\Listeners;

use App\Events\EventCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ChatChannel;

class CreateEventChatChannel
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventCreated $event): void
    {
        $eventData = $event->event;

        ChatChannel::create([
            'event_id' => $eventData->id,
            'name' => $eventData->title . ' Chat Channel'
        ]);
    }
}