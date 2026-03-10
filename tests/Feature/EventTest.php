<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class EventTest extends TestCase
{
    public function test_event_creation()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->post('/api/events', [
            'title' => 'Test Event'
        ]);

        $response->assertStatus(200);
    }
}