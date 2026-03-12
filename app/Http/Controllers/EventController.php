<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateEventRequest;

use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\UpdateEventDTO;

use App\Actions\Event\CreateEventAction;
use App\Actions\Event\UpdateEventAction;
use App\Actions\Event\DeleteEventAction;

use App\Models\Event;

class EventController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | EVENTS LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $events = Event::where('organization_id', auth()->user()->organization_id)
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('events.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE EVENT
    |--------------------------------------------------------------------------
    */

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

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW EVENT
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $event = Event::where('organization_id', auth()->user()->organization_id)
            ->findOrFail($id);

        return view('events.show', compact('event'));
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT PAGE
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE EVENT
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id, UpdateEventAction $action)
    {
        $event = Event::findOrFail($id);

        $this->authorize('update', $event);

        $dto = new UpdateEventDTO(
            $id,
            $request->title,
            $request->description,
            $request->start_time,
            $request->end_time
        );

        $action->execute($dto);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE EVENT
    |--------------------------------------------------------------------------
    */

    public function destroy($id, DeleteEventAction $action)
    {
        $event = Event::findOrFail($id);

        $this->authorize('delete', $event);

        $action->execute($id);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully');
    }

}