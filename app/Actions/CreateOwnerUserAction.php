<?php

namespace App\Actions;

use App\Models\User;
use App\DTO\RegisterOrganizationDTO;
use Illuminate\Support\Facades\Hash;

class CreateOwnerUserAction
{
    public function execute(RegisterOrganizationDTO $dto, $organizationId)
    {
        return User::create([
            'organization_id' => $organizationId,
            'name' => $dto->ownerName,
            'email' => $dto->ownerEmail,
            'password' => Hash::make($dto->password),
            'role' => 'owner'
        ]);
    }
}