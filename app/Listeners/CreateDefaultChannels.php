<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\Channel;

class CreateDefaultChannels
{

public function handle(EventCreated $event)
{

Channel::create([
'name'=>'General',
'event_id'=>$event->event->id
]);

}

}