<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Attendee;
use App\Actions\Dashboard\GetOwnerDashboardDataAction;

class DashboardController extends Controller
{
    public function index(Request $request, GetOwnerDashboardDataAction $dashboardAction)
    {
        $orgId = auth()->user()->organization_id;

        // Total events, attendees, and attendance rate via action
        $dashboardData = $dashboardAction->execute(
            $orgId,
            auth()->user()->role === 'owner' // load events with attendees only for owner
        );

        // Keep old variable names so your Blade works without changes
        $totalEvents = $dashboardData->totalEvents;
        $totalAttendees = $dashboardData->totalAttendees;
        $attendanceRate = $dashboardData->attendanceRate;

        return view('dashboard.index', compact(
            'totalEvents',
            'totalAttendees',
            'attendanceRate',
            'dashboardData', // optionally pass full data if you want events in Blade
            'orgId'
        ));
    }
}