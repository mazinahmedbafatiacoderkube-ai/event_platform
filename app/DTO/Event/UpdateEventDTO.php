<?php

namespace App\DTO\Event;

class UpdateEventDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $start_time,
        public string $end_time
    ) {}
}