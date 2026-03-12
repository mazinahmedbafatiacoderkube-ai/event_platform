<?php

namespace App\Services;

use App\Repositories\LandingRepository;

class LandingService
{

    protected $repo;

    public function __construct(LandingRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getOrganizations()
    {
        return $this->repo->allOrganizations();
    }

    public function getOrganizationEvents($orgId)
    {
        return $this->repo->eventsByOrganization($orgId);
    }

}