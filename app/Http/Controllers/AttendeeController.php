<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttendeeService;

class AttendeeController extends Controller
{

    protected $service;

    public function __construct(AttendeeService $service)
    {
        $this->service = $service;
    }

    /* SHOW BOOK TICKET PAGE */
    public function index($event)
    {
        return view('landing.book', compact('event'));
    }

    /* BOOK TICKET */
    public function store(Request $request, $event)
    {
        $this->service->register($request, $event);

        return back()->with('success','Ticket booked successfully!');
    }

}