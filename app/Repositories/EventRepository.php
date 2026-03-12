<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function create(array $data)
    {
        return Event::create($data);
    }

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

    public function delete($id)
    {
        return Event::destroy($id);
    }
}