<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Attendee;

class DashboardController extends Controller
{

public function index(Request $request)
{

$orgId = auth()->user()->organization_id;

// Total events of this organization
$totalEvents = Event::where('organization_id', $orgId)->count();

// Total attendees for events of this organization
$totalAttendees = Attendee::whereHas('event', function ($query) use ($orgId) {
    $query->where('organization_id', $orgId);
})->count();

// Attendance Rate
if ($totalEvents > 0) {
    $attendanceRate = round(($totalAttendees / ($totalEvents * 10)) * 100);
} else {
    $attendanceRate = 0;
}

return view('dashboard.index', compact(
'totalEvents',
'totalAttendees',
'attendanceRate'
));

}

}