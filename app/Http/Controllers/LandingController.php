<?php

namespace App\Http\Controllers;

use App\Services\LandingService;

class LandingController extends Controller
{

    public function index(LandingService $service)
    {
        $organizations = $service->getOrganizations();

        return view('landing.index', compact('organizations'));
    }

    public function events($id, LandingService $service)
    {
        $events = $service->getOrganizationEvents($id);

        return view('landing.events', compact('events'));
    }

}