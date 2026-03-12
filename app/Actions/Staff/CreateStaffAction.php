<?php

namespace App\Actions\Staff;

use App\Services\StaffService;
use App\DTO\CreateStaffDTO;

class CreateStaffAction
{
    public function __construct(
        protected StaffService $staffService
    ) {}

    public function execute(CreateStaffDTO $dto)
    {
        return $this->staffService->createStaff($dto);
    }
}