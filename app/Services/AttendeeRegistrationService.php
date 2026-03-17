<?php
namespace App\Services;

use App\DTO\AttendeeRegistrationDTO;
use App\Repositories\AttendeeRegistrationRepository;
use Illuminate\Support\Facades\Hash;

class AttendeeRegistrationService
{
    protected $repo;

    public function __construct(AttendeeRegistrationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(AttendeeRegistrationDTO $dto)
    {
        if ($this->repo->findByEmail($dto->email)) {
            throw new \Exception('Email already registered');
        }

        return $this->repo->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }
}