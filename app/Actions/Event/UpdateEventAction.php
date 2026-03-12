<?php

namespace App\Actions\Event;

use App\DTO\Event\UpdateEventDTO;
use App\Repositories\EventRepository;
use App\Models\Event;

class UpdateEventAction
{
    protected EventRepository $repo;

    public function __construct(EventRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute(UpdateEventDTO $dto): Event
    {
        return $this->repo->update($dto);
    }
}