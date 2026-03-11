<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function index(Request $request)
{

$totalEvents = 12;
$totalAttendees = 120;
$attendanceRate = 75;

return view('dashboard.index', compact(
'totalEvents',
'totalAttendees',
'attendanceRate'
));

}

}