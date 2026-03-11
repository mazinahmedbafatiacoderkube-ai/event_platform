<?php

namespace App\Repositories;

use App\Models\Attendee;

class AttendeeRepository
{

public function getByEvent($eventId)
{
return Attendee::where('event_id',$eventId)->get();
}

public function create($data)
{
return Attendee::create($data);
}

}