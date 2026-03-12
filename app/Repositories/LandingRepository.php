<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\Event;

class LandingRepository
{

    public function allOrganizations()
    {
        return Organization::latest()->get();
    }

    public function eventsByOrganization($orgId)
    {
        return Event::where('organization_id',$orgId)
                    ->latest()
                    ->get();
    }

}