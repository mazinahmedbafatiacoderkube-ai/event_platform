<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventAttendeeController extends Controller
{
    // Show attendees for an event (owner dashboard)
    public function index($eventId)
    {
        $event = Event::with('attendees')->findOrFail($eventId);

        return view('events.attendees', compact('event'));
    }
}