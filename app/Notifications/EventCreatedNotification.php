<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    private $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'message' => "New event '{$this->event->title}' created."
        ];
    }
}