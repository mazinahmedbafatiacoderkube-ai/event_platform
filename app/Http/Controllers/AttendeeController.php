<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttendeeService;
use Illuminate\Support\Facades\Mail;

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
        // SAVE ATTENDEE
        $this->service->register($request, $event);

        // SEND EMAIL AFTER BOOKING
        Mail::raw('Your ticket has been booked successfully.', function ($message) use ($request) {
            $message->from('tigercub@yourdomain.com', 'TigerCub')
                    ->to($request->email)
                    ->subject('Ticket Booking Confirmation');
        });

        return back()->with('success','Ticket booked successfully!');
    }

}