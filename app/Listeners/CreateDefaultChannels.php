<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\Channel;

class CreateDefaultChannels
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\EventCreated  $event
     * @return void
     */
    public function handle(EventCreated $event)
    {
        Channel::create([
            'event_id' => $event->event->id,
            'name'     => 'general',
        ]);
    }
}
