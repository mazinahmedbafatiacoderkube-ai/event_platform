<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Event;

class SendEventCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public string $eventTitle;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $eventTitle)
    {
        $this->email = $email;
        $this->eventTitle = $eventTitle;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw(
            "You are invited to event: {$this->eventTitle}",
            function ($message) {
                $message->to($this->email)
                        ->subject("Event Invitation");
            }
        );
    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error("Failed to send event email to {$this->email}: {$exception->getMessage()}");
    }
}