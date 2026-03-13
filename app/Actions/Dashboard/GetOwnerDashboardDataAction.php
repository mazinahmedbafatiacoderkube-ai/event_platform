<?php

namespace App\Actions\Dashboard;

use App\Repositories\EventRepository;
use App\Repositories\AttendeeRepository;
use App\DTO\Dashboard\DashboardDataDTO;

class GetOwnerDashboardDataAction
{
    protected EventRepository $eventRepo;
    protected AttendeeRepository $attendeeRepo;

    public function __construct(EventRepository $eventRepo, AttendeeRepository $attendeeRepo)
    {
        $this->eventRepo = $eventRepo;
        $this->attendeeRepo = $attendeeRepo;
    }

    /**
     * Execute the dashboard logic
     * 
     * @param int $organizationId
     * @param bool $withEvents Load attendees per event for owners
     * @return DashboardDataDTO
     */
    public function execute(int $organizationId, bool $withEvents = false): DashboardDataDTO
    {
        // Total events
        $totalEvents = $this->eventRepo->countEventsByOrganization($organizationId);

        // Total attendees
        $totalAttendees = $this->attendeeRepo->countAttendeesByOrganization($organizationId);

        // Attendance rate (assume 10 expected per event)
        $attendanceRate = $totalEvents > 0 
            ? round(($totalAttendees / ($totalEvents * 10)) * 100)
            : 0;

        // Load events with attendees if needed
        $events = $withEvents ? $this->eventRepo->getEventsWithAttendees($organizationId) : null;

        return new DashboardDataDTO($totalEvents, $totalAttendees, $attendanceRate, $events);
    }
}