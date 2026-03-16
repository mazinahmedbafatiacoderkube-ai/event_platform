<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Dashboard\GetOwnerDashboardDataAction;

class DashboardController extends Controller
{
    public function index(Request $request, GetOwnerDashboardDataAction $dashboardAction)
    {
        $orgId = auth()->user()->organization_id;

        // Dashboard data via action
        $dashboardData = $dashboardAction->execute(
            $orgId,
            auth()->user()->role === 'owner'
        );

        // Variables used in blade
        $totalEvents = $dashboardData->totalEvents;
        $totalAttendees = $dashboardData->totalAttendees;
        $attendanceRate = $dashboardData->attendanceRate;

        return view('dashboard.index', compact(
            'totalEvents',
            'totalAttendees',
            'attendanceRate',
            'dashboardData',
            'orgId'
        ));
    }
}