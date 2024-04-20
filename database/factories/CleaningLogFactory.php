<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CleaningLogs>
 */
class CleaningLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //room_id
            //employee_id
            'datetime' => $this->faker->dateTime(),
            'note' => $this->faker->sentence()
        ];
    }
}
