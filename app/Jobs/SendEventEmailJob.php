<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $eventTitle;

    public function __construct($email, $eventTitle)
    {
        $this->email = $email;
        $this->eventTitle = $eventTitle;
    }

    public function handle()
    {
        Mail::raw(
            "You are invited to event: " . $this->eventTitle,
            function ($message) {
                $message->to($this->email)
                        ->subject("Event Invitation");
            }
        );
    }
}