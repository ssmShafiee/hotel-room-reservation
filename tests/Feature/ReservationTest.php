<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    //for refreshing database before executing tests
    use RefreshDatabase;

    /** @test */
    public function user_can_reserve_a_room_if_it_is_available()
    {
        //create sample room
        $room = Room::factory()->create([
            'capacity' => 3,
        ]);

        //reservation request
        $response = $this->postJson('/api/reserve', [
            'room_id' => $room->id,
        ]);

        //check for response
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'رزرو با موفقیت انجام شد.',
        ]);

        //check database
        $this->assertDatabaseHas('reservations', [
            'room_id' => $room->id,
            'status' => 'active',
        ]);
    }

    /** @test */
    public function user_cannot_reserve_a_room_that_is_already_reserved()
    {
        //create sample room
        $room = Room::factory()->create();

        //reservation this room
        Reservation::create([
            'room_id' => $room->id,
            'reserved_at' => now(),
            'expires_at' => now()->addMinutes(2),
            'status' => 'active',
        ]);

        //try to reserve for second time the same room
        $response = $this->postJson('/api/reserve', [
            'room_id' => $room->id,
        ]);

        //check response for already reserve
        $response->assertStatus(409);
        $response->assertJson([
            'message' => 'این اتاق در حال حاضر رزرو شده است.',
        ]);

        //check database
        $this->assertCount(1, Reservation::all());
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
