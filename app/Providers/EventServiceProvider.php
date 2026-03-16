<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\EventCreated;

use App\Listeners\SendEventNotificationListener;
use App\Listeners\CreateEventAnalyticsListener;
use App\Listeners\GenerateDefaultChatChannelsListener;
use App\Listeners\CreateEventChatChannel;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EventCreated::class => [
            SendEventNotificationListener::class,
            CreateEventAnalyticsListener::class,
            CreateEventChatChannel::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}       