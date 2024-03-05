<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestDocuments>
 */
class GuestDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //guest_id
            'document_country' => $this->faker->countryCode(),
            'document_serial' => $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
            'document_number' => $this->faker->numberBetween(100000,999999),
            'document_expired' => $this->faker->dateTimeThisDecade('+10 years'),
            'document_issued_by' => $this->faker->sentence(),
            'document_issued_date' => $this->faker->dateTimeThisDecade('-5 years'),
        ];
    }
}
