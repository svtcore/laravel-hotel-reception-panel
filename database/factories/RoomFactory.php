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
            'floor' => $this->faker->numberBetween(1, 5),
            'door_number' => $this->faker->numberBetween(1, 1000),
            'type' => $this->faker->randomElement(['standart','comfort','premium','king']),
            'area' => $this->faker->randomFloat(1, 10, 250),
            'room_amount' => $this->faker->numberBetween(1, 10),
            'bed_amount' =>  $this->faker->randomElement([1, 2, 4, 10]),
            'children_bed_amount' => $this->faker->numberBetween(0,3),
            'price' => $this->faker->randomFloat(1, 100, 5000),
            'status' => $this->faker->randomElement(['busy', 'free', 'maintence', 'reserved']),
        ];
    }
}
