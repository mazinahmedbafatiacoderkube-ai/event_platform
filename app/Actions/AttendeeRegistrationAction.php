<?php
namespace App\Actions;

use App\DTO\AttendeeRegistrationDTO;
use App\Services\AttendeeRegistrationService;

class AttendeeRegistrationAction
{
    protected $service;

    public function __construct(AttendeeRegistrationService $service)
    {
        $this->service = $service;
    }

    public function execute(AttendeeRegistrationDTO $dto)
    {
        return $this->service->register($dto);
    }
}