<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{

    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    /**
     * Display list of events
     */
    public function index()
    {
        $events = $this->service->list();

        return view('events.index', compact('events'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store new event
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date'
        ]);

        $validated['created_by'] = auth()->id();

        $this->service->create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully');
    }

    /**
     * Show single event
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update event
     */
    public function update(Request $request, $id)
    {

        $event = Event::findOrFail($id);

        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Delete event
     */
    public function destroy($id)
    {

        $event = Event::findOrFail($id);

        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }
}