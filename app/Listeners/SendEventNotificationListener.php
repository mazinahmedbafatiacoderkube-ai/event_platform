<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEventNotificationListener
{
    public function handle(EventCreated $event)
    {
        // Example: Send email to all organization users
        $users = User::where('organization_id', $event->event->organization_id)->get();

        foreach ($users as $user) {
            // You can replace this with Mailables
            Mail::raw("A new event '{$event->event->title}' has been created.", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('New Event Created');
            });
        }
    }
}