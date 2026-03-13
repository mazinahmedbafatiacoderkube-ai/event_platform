<?php

namespace App\Repositories;

use App\Models\Event;
use App\Events\EventCreated;

class EventRepository
{
    /**
     * Simple create method (does NOT dispatch EventCreated)
     */
    public function create(array $data)
    {
        return Event::create($data);
    }

    /**
     * Create from DTO and fire EventCreated
     */
    public function createFromDTO($dto)
    {
        $event = Event::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'start_time' => $dto->startTime,
            'end_time' => $dto->endTime,
            'organization_id' => $dto->organizationId,
        ]);

        // Fire EventCreated event
        EventCreated::dispatch($event);

        return $event;
    }

    /**
     * Update event using DTO
     */
    public function update($dto)
    {
        $event = Event::findOrFail($dto->id);

        $event->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'start_time' => $dto->startTime,
            'end_time' => $dto->endTime
        ]);

        return $event;
    }

    /**
     * Delete event
     */
    public function delete($id)
    {
        return Event::destroy($id);
    }

    /**
     * Count all events for an organization
     */
    public function countEventsByOrganization(int $orgId): int
    {
        return Event::where('organization_id', $orgId)->count();
    }

    /**
     * Get all events with attendees for an organization
     */
    public function getEventsWithAttendees(int $orgId)
    {
        return Event::with('attendees')
            ->where('organization_id', $orgId)
            ->get();
    }
}