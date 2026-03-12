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
            'start_time' => $dto->startTime,
            'end_time' => $dto->endTime,
            'status' => 'scheduled',
            'created_by' => $dto->createdBy
        ]);
    }
}