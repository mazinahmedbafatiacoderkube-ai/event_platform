<?php

namespace App\Services;

use App\Models\User;
use App\DTO\CreateStaffDTO;

class StaffService
{
    public function createStaff(CreateStaffDTO $dto)
    {
        return User::create([
            'organization_id' => $dto->organization_id,
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role,
        ]);
    }

    public function listStaff($organizationId)
    {
        return User::where('organization_id', $organizationId)
            ->where('role', 'event_manager')
            ->get();
    }
    public function deleteStaff($id)
{
    return User::where('organization_id', auth()->user()->organization_id)
                ->where('id', $id)
                ->delete();
}
}