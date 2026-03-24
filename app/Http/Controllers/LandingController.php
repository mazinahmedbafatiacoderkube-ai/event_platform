<?php

namespace App\Http\Controllers;

use App\Services\LandingService;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Organization; // Make sure this exists

class LandingController extends Controller
{
    public function index(LandingService $service)
    {
        // Logged-in attendee
        $user = Auth::guard('attendee')->user();

        // Fetch all upcoming events
        $events = Event::latest()->get();

        // Fetch all organizations to display
        $organizations = Organization::all();

        // Fetch this attendee's booked tickets
        $bookedTickets = Attendee::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing.index', compact('user', 'events', 'organizations', 'bookedTickets'));
    }

    public function events($id, LandingService $service)
    {
        $events = $service->getOrganizationEvents($id);
        return view('landing.events', compact('events'));
    }
}