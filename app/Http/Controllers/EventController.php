<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->getEvents($request->user()->organization_id);
    }

    public function store(Request $request)
    {
        return $this->service->createEvent($request->all());
    }
}