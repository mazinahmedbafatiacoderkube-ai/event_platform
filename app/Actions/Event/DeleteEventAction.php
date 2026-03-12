<?php

namespace App\Actions\Event;

use App\Repositories\EventRepository;

class DeleteEventAction
{
    protected $repo;

    public function __construct(EventRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute($id)
    {
        return $this->repo->delete($id);
    }
}