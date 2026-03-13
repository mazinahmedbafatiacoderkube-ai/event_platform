<?php

namespace App\Repositories;

use App\Models\Attendee;

class AttendeeRepository
{
    public function getByEvent($eventId)
    {
        return Attendee::where('event_id', $eventId)->get();
    }

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
}