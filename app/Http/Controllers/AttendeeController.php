<?php

namespace App\Http\Controllers;

use App\Services\AttendeeService;

class AttendeeController extends Controller
{

protected $service;

public function __construct(AttendeeService $service)
{
$this->service = $service;
}

public function index($eventId)
{

$attendees = $this->service->list($eventId);

return view('attendees.index',compact('attendees'));

}

}