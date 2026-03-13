<?php
namespace App\DTO\Dashboard;

class DashboardDataDTO
{
    public int $totalEvents;
    public int $totalAttendees;
    public float $attendanceRate;
    public $events; // optional: collection of events with attendees

    public function __construct(int $totalEvents, int $totalAttendees, float $attendanceRate, $events = null)
    {
        $this->totalEvents = $totalEvents;
        $this->totalAttendees = $totalAttendees;
        $this->attendanceRate = $attendanceRate;
        $this->events = $events;
    }
}