<?php

namespace App\Actions;

use App\Models\Organization;
use App\DTO\RegisterOrganizationDTO;

class CreateOrganizationAction
{
    public function execute(RegisterOrganizationDTO $dto)
    {
        return Organization::create([
            'name' => $dto->organizationName,
            'plan' => $dto->plan
        ]);
    }
}