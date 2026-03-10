<?php
namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function all($organizationId)
    {
        return Event::where('organization_id', $organizationId)->get();
    }

    public function find($id)
    {
        return Event::findOrFail($id);
    }

    public function create(array $data)
    {
        return Event::create($data);
    }

    public function update($id, array $data)
    {
        $event = Event::findOrFail($id);
        $event->update($data);
        return $event;
    }

    public function delete($id)
    {
        return Event::destroy($id);
    }
}