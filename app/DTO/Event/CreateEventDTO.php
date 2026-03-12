<?php

namespace App\DTO\Event;

class CreateEventDTO
{
    public function __construct(
        public int $organizationId,
        public string $title,
        public string $description,
        public string $startTime,
        public string $endTime,
        public int $createdBy
    ) {}
}
