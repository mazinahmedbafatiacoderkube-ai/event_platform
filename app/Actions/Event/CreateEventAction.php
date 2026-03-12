<?php

namespace App\Actions\Event;

use App\Services\EventService;
use App\DTO\Event\CreateEventDTO;

class CreateEventAction
{
    public function __construct(private EventService $service) {}

    public function execute(CreateEventDTO $dto)
    {
        return $this->service->createEvent($dto);
    }
}