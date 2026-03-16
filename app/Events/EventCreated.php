<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCreated
{
    use Dispatchable, SerializesModels;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }
}