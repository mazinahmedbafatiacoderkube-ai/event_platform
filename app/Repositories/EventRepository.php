<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{

public function getAll()
{
return Event::latest()->get();
}

public function find($id)
{
return Event::findOrFail($id);
}

public function create($data)
{
return Event::create($data);
}

public function delete($event)
{
return $event->delete();
}

}