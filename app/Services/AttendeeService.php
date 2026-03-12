<?php

namespace App\Services;

use App\Repositories\AttendeeRepository;

class AttendeeService
{

protected $repo;

public function __construct(AttendeeRepository $repo)
{
$this->repo = $repo;
}

public function list($eventId)
{
return $this->repo->getByEvent($eventId);
}

public function register($request,$eventId)
{

$request->validate([
'name' => 'required',
'email' => 'required|email'
]);

$data = [
'name' => $request->name,
'email' => $request->email,
'event_id' => $eventId,
 'ticket_type' => $request->ticket_type
];

return $this->repo->create($data);

}

}