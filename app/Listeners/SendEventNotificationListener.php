<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\User;
use App\Notifications\EventCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendEventNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(EventCreated $event): void
    {
        // Get all users of the same organization
        $users = User::where('organization_id', $event->event->organization_id)->get();

        // Send notification to those users
        Notification::send($users, new EventCreatedNotification($event->event));
    }
}