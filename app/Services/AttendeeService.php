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

public function register($data)
{
return $this->repo->create($data);
}

}