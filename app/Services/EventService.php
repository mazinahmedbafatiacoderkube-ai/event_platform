<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Events\EventCreated;

class EventService
{

protected $repo;

public function __construct(EventRepository $repo)
{
$this->repo = $repo;
}

public function list()
{
return $this->repo->getAll();
}

public function create($data)
{

$event = $this->repo->create($data);

event(new EventCreated($event));

return $event;

}

}