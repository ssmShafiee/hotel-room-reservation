<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{

    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Room '.$this->faker->unique()->numberBetween(100, 999),
            'floor' => $this->faker->numberBetween(1, 5),
            'room_type' => $this->faker->randomElement(['single', 'double', 'family']),
            'capacity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
