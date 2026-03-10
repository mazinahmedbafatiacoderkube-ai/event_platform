<?php
namespace App\Services;

use App\Repositories\EventRepository;
use App\Events\EventCreated;

class EventService
{
    protected $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createEvent($data)
    {
        $event = $this->repository->create($data);

        event(new EventCreated($event));

        return $event;
    }

    public function getEvents($orgId)
    {
        return $this->repository->all($orgId);
    }
}