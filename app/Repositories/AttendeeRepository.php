<?php

namespace App\Repositories;

use App\Models\Attendee;

class AttendeeRepository
{
    /**
     * Get all attendees for a specific event
     */
    public function getByEvent($eventId)
    {
        return Attendee::where('event_id', $eventId)->get();
    }

    /**
     * Create a new attendee
     */
    public function create($data)
    {
        return Attendee::create($data);
    }

    /**
     * Count all attendees for a given organization
     *
     * @param int $organizationId
     * @return int
     */
    public function countAttendeesByOrganization(int $organizationId): int
    {
        return Attendee::whereHas('event', function ($query) use ($organizationId) {
            $query->where('organization_id', $organizationId);
        })->count();
    }

    /**
     * Count attendees for events created by a specific user
     * (Event Manager dashboard)
     *
     * @param int $userId
     * @return int
     */
    public function countAttendeesByUserEvents($userId): int
    {
        return Attendee::whereHas('event', function ($query) use ($userId) {
            $query->where('created_by', $userId);
        })->count();
    }
}