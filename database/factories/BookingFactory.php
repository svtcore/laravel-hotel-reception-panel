<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookings>
 */
class BookingFactory extends Factory
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
            'adults_count' => $this->faker->numberBetween(1,10),
            'children_count' => $this->faker->numberBetween(0,4),
            'total_cost' => $this->faker->numberBetween(1000, 10000),
            'payment_type' => $this->faker->randomElement(['credit_card', 'cash']),
            'check_in_date' => $this->faker->dateTimeInInterval('-7 days', '+14 days'),
            'check_out_date' => $this->faker->dateTimeInInterval('now', '+14 days'),
            'note' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['reserved', 'cancelled', 'active', 'expired', 'completed']),
        ];
    }
}
