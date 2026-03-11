<?php

namespace App\Repositories;

use App\Models\Organization;

class OrganizationRepository
{
    public function create(array $data)
    {
        return Organization::create([
            'name' => $data['name'],
            'owner_id' => $data['owner_id'],
            'plan' => $data['plan']
        ]);
    }
}