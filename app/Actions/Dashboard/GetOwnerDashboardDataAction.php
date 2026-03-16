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

    public function execute(int $organizationId, bool $isOwner = false): DashboardDataDTO
    {
        if ($isOwner) {

            // Owner → all events in organization
            $totalEvents = $this->eventRepo->countEventsByOrganization($organizationId);

            $totalAttendees = $this->attendeeRepo->countAttendeesByOrganization($organizationId);

            $events = $this->eventRepo->getEventsWithAttendees($organizationId);

        } else {

            // User → only his events
            $userId = auth()->id();

            $totalEvents = $this->eventRepo->countEventsByUser($userId);

            $totalAttendees = $this->attendeeRepo->countAttendeesByUserEvents($userId);

            $events = $this->eventRepo->getEventsWithAttendeesByUser($userId);

        }

        $attendanceRate = $totalEvents > 0
            ? round(($totalAttendees / ($totalEvents * 10)) * 100)
            : 0;

        return new DashboardDataDTO($totalEvents, $totalAttendees, $attendanceRate, $events);
    }
}