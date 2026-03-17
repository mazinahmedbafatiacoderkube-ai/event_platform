<?php

namespace App\Http\Controllers;
use App\Services\LandingService;
use Illuminate\Support\Facades\Auth;
class LandingController extends Controller
{

    public function index(LandingService $service)
    {

        $attendee = Auth::guard('attendee')->user();

        $organizations = \App\Models\Organization::latest()->get();

        // ✅ Get tickets of logged-in attendee
        $tickets = \App\Models\Attendee::where('attendee_id', $attendee->id)->get();
        
        $events = \App\Models\Event::latest()->get();


        return view('landing.index', compact('attendee', 'organizations', 'tickets','events'));
    }

    public function events($id, LandingService $service)
    {
        $events = $service->getOrganizationEvents($id);

        return view('landing.events', compact('events'));
    }

}