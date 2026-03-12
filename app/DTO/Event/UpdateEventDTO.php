<?php

namespace App\DTO\Event;

class UpdateEventDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $startTime,
        public string $endTime
    ) {}
}