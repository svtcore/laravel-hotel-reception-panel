<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rooms>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'floor_number' => $this->faker->numberBetween(1, 5),
            'room_number' => $this->faker->numberBetween(1, 1000),
            'type' => $this->faker->randomElement(['standard', 'deluxe', 'suite', 'penthouse']),
            'total_rooms' => $this->faker->numberBetween(1, 10),
            'adults_beds_count' =>  $this->faker->randomElement([1, 2, 4, 10]),
            'children_beds_count' => $this->faker->numberBetween(0,3),
            'price' => $this->faker->randomFloat(1, 100, 5000),
            'status' => $this->faker->randomElement(['occupied', 'available', 'under_maintenance']),
        ];
    }
}
