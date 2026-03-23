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
use App\Events\EventCreated;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Jobs\SendEventCreatedEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth; // make sure this is imported

class EventController extends Controller
{
    use AuthorizesRequests;

    /*
    |----------------------------------------------------------------------|
    | EVENTS LIST                                                            |
    |----------------------------------------------------------------------|
    */
    public function index()
    {
        $events = Cache::remember('events_list_' . Auth::user()->organization_id, 300, function () {
            return Event::where('organization_id', Auth::user()->organization_id)
                ->latest()
                ->get();
        });

        return view('events.index', compact('events'));
    }

    /*
    |----------------------------------------------------------------------|
    | CREATE PAGE                                                            |
    |----------------------------------------------------------------------|
    */
    public function create()
    {
        return view('events.create');
    }

    /*
    |----------------------------------------------------------------------|
    | STORE EVENT                                                            |
    |----------------------------------------------------------------------|
    */
    public function store(CreateEventRequest $request, CreateEventAction $action)
    {
        // ✅ Use the proper DTO class
        $dto = new CreateEventDTO(
            Auth::user()->organization_id,
            $request->title,
            $request->description,
            $request->start_time,
            $request->end_time
        );

        $event = $action->execute($dto);

        // FIRE EVENT
        event(new EventCreated($event));

        // Dispatch the email job to send a notification about the new event
        SendEventCreatedEmail::dispatch(Auth::user(), $event->title);

        // Clear cached events after new event is created
        Cache::forget('events_list_' . Auth::user()->organization_id);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully');
    }

    /*
    |----------------------------------------------------------------------|
    | SHOW EVENT                                                             |
    |----------------------------------------------------------------------|
    */
    public function show($id)
    {
        $event = Event::where('organization_id', Auth::user()->organization_id)
            ->findOrFail($id);

        return view('events.show', compact('event'));
    }

    /*
    |----------------------------------------------------------------------|
    | EDIT PAGE                                                              |
    |----------------------------------------------------------------------|
    */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /*
    |----------------------------------------------------------------------|
    | UPDATE EVENT                                                           |
    |----------------------------------------------------------------------|
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

        Cache::forget('events_list_' . Auth::user()->organization_id);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /*
    |----------------------------------------------------------------------|
    | DELETE EVENT                                                           |
    |----------------------------------------------------------------------|
    */
    public function destroy($id, DeleteEventAction $action)
    {
        $event = Event::findOrFail($id);
        $this->authorize('delete', $event);

        $action->execute($id);

        Cache::forget('events_list_' . Auth::user()->organization_id);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully');
    }
}