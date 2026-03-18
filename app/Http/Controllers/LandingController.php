<?php

namespace App\Http\Controllers;

use App\Services\LandingService;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Organization;

class LandingController extends Controller
{
    public function index(LandingService $service)
    {
        // Logged-in attendee
        $attendee = Auth::guard('attendee')->user();

        // Eager-load event relationship
        $attendee->load('event');

        // Get all organizations
        $organizations = Organization::latest()->get();

        // Get all events
        $events = Event::latest()->get();

        // No separate tickets query is needed; ticket info is in $attendee
        return view('landing.index', compact('attendee', 'organizations', 'events'));
    }

    public function events($id, LandingService $service)
    {
        $events = $service->getOrganizationEvents($id);

        return view('landing.events', compact('events'));
    }
}