<?php
namespace App\Repositories;

use App\Models\AttendeeRegistration;

class AttendeeRegistrationRepository
{
    public function create(array $data): AttendeeRegistration
    {
        return AttendeeRegistration::create($data);
    }

    public function findByEmail(string $email): ?AttendeeRegistration
    {
        return AttendeeRegistration::where('email', $email)->first();
    }
}