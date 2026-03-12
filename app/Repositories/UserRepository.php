<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function getStaffByOrganization($orgId)
    {
        return User::where('organization_id',$orgId)
            ->where('role','event_manager')
            ->get();
    }
}