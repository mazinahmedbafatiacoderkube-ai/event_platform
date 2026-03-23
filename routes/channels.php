<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('event.{eventId}', function ($user, $eventId) {
    return true; // you can add tenant check later
});