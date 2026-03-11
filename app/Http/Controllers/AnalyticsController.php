<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{

protected $analytics;

public function __construct(AnalyticsService $analytics)
{
$this->analytics = $analytics;
}

public function index()
{

$stats = $this->analytics->getStats();

return view('analytics.index',compact('stats'));

}

}