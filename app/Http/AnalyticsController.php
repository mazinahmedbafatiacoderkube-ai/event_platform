<?php

namespace App\Http\Controllers;

class AnalyticsController extends Controller
{

public function index()
{

$stats=[
'total_events'=>15,
'total_attendees'=>300,
'attendance_rate'=>80
];

return view('analytics.index',compact('stats'));

}

}