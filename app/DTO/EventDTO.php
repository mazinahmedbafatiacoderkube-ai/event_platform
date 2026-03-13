<?php

namespace App\DTO;

class EventDTO
{
    public $title;
    public $description;
    public $startTime;
    public $endTime;
    public $organizationId;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->startTime = $data['start_time'] ?? null;
        $this->endTime = $data['end_time'] ?? null;
        $this->organizationId = $data['organization_id'] ?? null;
    }
}