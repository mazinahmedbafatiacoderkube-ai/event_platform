<?php


namespace App\Services;

use App\Repositories\EventRepository;
use App\DTO\Event\CreateEventDTO;

class EventService
{
    public function __construct(private EventRepository $repository) {}

    public function createEvent(CreateEventDTO $dto)
    {
        return $this->repository->create([
            'organization_id' => $dto->organizationId,
            'title' => $dto->title,
            'description' => $dto->description,
            'start_time' => $dto->start_time,
            'end_time' => $dto->end_time,
            'status' => 'scheduled',
            'created_by' => auth()->id()
        ]);
    }
}