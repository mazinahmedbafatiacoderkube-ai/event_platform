<?php

namespace App\DTO\Event;

class CreateEventDTO
{
    public function __construct(
        public int $organizationId,
        public string $title,
        public string $description,
        public string $start_time,
        public string $end_time
    ) {}
}