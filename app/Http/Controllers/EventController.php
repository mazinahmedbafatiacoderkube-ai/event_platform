<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateEventRequest;

use App\Models\Event;

use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\UpdateEventDTO;

use App\Actions\Event\CreateEventAction;
use App\Actions\Event\UpdateEventAction;
use App\Actions\Event\DeleteEventAction;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::latest()->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(CreateEventRequest $request, CreateEventAction $action)
    {
        $dto = new CreateEventDTO(
            auth()->user()->organization_id,
            $request->title,
            $request->description,
            $request->start_time,
            $request->end_time,
            auth()->id()
        );

        $action->execute($dto);

        return redirect()->route('events.index')
            ->with('success','Event created');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id, UpdateEventAction $action)
    {
        $dto = new UpdateEventDTO(
            $id,
            $request->title,
            $request->description,
            $request->start_time,
            $request->end_time
        );

        $action->execute($dto);

        return redirect()->route('events.index')
            ->with('success','Event updated');
    }

    public function destroy($id, DeleteEventAction $action)
    {
        $action->execute($id);

        return redirect()->route('events.index')
            ->with('success','Event deleted');
    }
}