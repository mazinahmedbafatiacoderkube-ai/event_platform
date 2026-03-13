<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\EventCreated;
use App\Listeners\SendEventNotificationListener;
use App\Listeners\CreateEventAnalyticsListener;
use App\Listeners\GenerateDefaultChatChannelsListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EventCreated::class => [
            SendEventNotificationListener::class,
            CreateEventAnalyticsListener::class,
            GenerateDefaultChatChannelsListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}