<?php

namespace App\Repositories;

use App\Models\Event;
use App\DTO\Event\UpdateEventDTO;

class EventRepository
{
    public function create(array $data)
    {
        return Event::create($data);
    }

    public function update(UpdateEventDTO $dto)
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

    public function delete(int $id)
    {
        return Event::destroy($id);
    }
}