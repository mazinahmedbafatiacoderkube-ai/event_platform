<?php

namespace App\Events;

use App\Models\Event;

class EventCreated
{

public $event;

public function __construct(Event $event)
{
$this->event = $event;
}

}