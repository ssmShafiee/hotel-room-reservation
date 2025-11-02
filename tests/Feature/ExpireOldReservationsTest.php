<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Reservation;

class ExpireOldReservationsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_expires_old_reservations_and_keeps_active_ones()
    {
        //create sample room
        $room = Room::factory()->create();

        //create an expired reservation
        $expiredReservation = Reservation::create([
            'room_id' => $room->id,
            'reserved_at' => now()->subMinutes(5),
            'expires_at' => now()->subMinutes(3),
            'status' => 'active',
        ]);

        //create an active reservation
        $activeReservation = Reservation::create([
            'room_id' => $room->id,
            'reserved_at' => now(),
            'expires_at' => now()->addMinutes(2),
            'status' => 'active',
        ]);

        //call expire method
        $response = $this->postJson('/api/expire');

        //check response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'تعداد 1 رزرو منقضی شد.',
        ]);

        //check reservations in database
        $this->assertDatabaseHas('reservations', [
            'id' => $expiredReservation->id,
            'status' => 'expired',
        ]);

        $this->assertDatabaseHas('reservations', [
            'id' => $activeReservation->id,
            'status' => 'active',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
