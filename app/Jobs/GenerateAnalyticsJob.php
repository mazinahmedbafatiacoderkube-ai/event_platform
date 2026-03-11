<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateAnalyticsJob implements ShouldQueue
{

use Dispatchable, Queueable;

public function handle()
{

$totalEvents = Event::count();

\Log::info('Total events: '.$totalEvents);

}

}