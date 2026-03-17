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
            'start_time' => $dto->start_time,
            'end_time' => $dto->end_time,
            'organization_id' => $dto->organizationId,

            // IMPORTANT: store which user created the event
            'created_by' => auth()->id(),
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
            'start_time' => $dto->start_time,
            'end_time' => $dto->end_time
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
     * Count all events for an organization (Owner dashboard)
     */
    public function countEventsByOrganization(int $orgId): int
    {
        return Event::where('organization_id', $orgId)->count();
    }

    /**
     * Get all events with attendees for an organization (Owner dashboard)
     */
    public function getEventsWithAttendees(int $orgId)
    {
        return Event::with('attendees')
            ->where('organization_id', $orgId)
            ->get();
    }

    /**
     * Count events created by a specific user (Event Manager dashboard)
     */
    public function countEventsByUser($userId)
    {
        return Event::where('created_by', $userId)->count();
    }

    /**
     * Get events with attendees created by a specific user
     */
    public function getEventsWithAttendeesByUser($userId)
    {
        return Event::with('attendees')
            ->where('created_by', $userId)
            ->get();
    }
}