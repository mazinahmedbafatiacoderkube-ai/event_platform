<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEventCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $eventTitle;

    public function __construct(User $user, $eventTitle)
    {
        $this->user = $user;
        $this->eventTitle = $eventTitle;
    }

    public function handle()
    {
        Mail::raw("A new event '{$this->eventTitle}' has been created!", function ($message) {
            $message->to($this->user->email)
                ->subject('New Event Created');
        });
    }
}