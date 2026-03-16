<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\Channel;
use App\Models\ChatChannel;

class CreateDefaultChannels
{

    public function handle(EventCreated $event)
    {

        ChatChannel::create([
            'name' => 'General',
            'event_id' => $event->event->id
        ]);

    }

}