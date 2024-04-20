<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(),
            'dob' => $this->faker->date(),
            'phone_number' => $this->faker->numerify('380#########'),
            'position' => $this->faker->word(),
            'status' => $this->faker->randomElement(['active', 'fired', 'vacation', 'other'])
        ];
    }
}
