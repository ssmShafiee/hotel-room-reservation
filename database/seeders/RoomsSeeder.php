<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Room 101',
                'floor' => '1',
                'room_type' => 'single',
                'capacity' => 1,
            ],
            [
                'name' => 'Room 102',
                'floor' => '1',
                'room_type' => 'double',
                'capacity' => 2,
            ],
            [
                'name' => 'Room 201',
                'floor' => '2',
                'room_type' => 'family',
                'capacity' => 4,
            ],
            [
                'name' => 'Room 202',
                'floor' => '2',
                'room_type' => 'suite',
                'capacity' => 3,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
