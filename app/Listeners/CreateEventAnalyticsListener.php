<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\Analytics;

class CreateEventAnalyticsListener
{
    public function handle(EventCreated $event)
    {
        // Create a default analytics record for this event
        Analytics::create([
            'event_id' => $event->event->id,
            'views' => 0,
            'registrations' => 0,
            'organization_id' => $event->event->organization_id
        ]);
    }
}