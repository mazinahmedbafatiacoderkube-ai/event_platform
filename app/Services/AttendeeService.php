<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Attendee;

class AttendeeService
{
    public function register(Request $request, $eventId)
    {
        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ticket_type' => 'required|string|max:50',
        ]);

        // ✅ Save directly into "attendees" table
        $attendee = Attendee::create([
            'name' => $request->name,
            'email' => $request->email,
            'ticket_type' => $request->ticket_type,
            'event_id' => $eventId,
        ]);

        return $attendee;
    }
}