<?php

namespace App\Actions\Event;

use App\DTO\Event\UpdateEventDTO;
use App\Repositories\EventRepository;

class UpdateEventAction
{
    protected $repo;

    public function __construct(EventRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute(UpdateEventDTO $dto)
    {
        return $this->repo->update($dto);
    }
}