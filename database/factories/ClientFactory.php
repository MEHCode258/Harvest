<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Generate a company name
            'email' => $this->faker->unique()->safeEmail, // Generate a unique email
            'phone' => $this->faker->phoneNumber, // Generate a phone number
            'add1' => $this->faker->streetAddress, // Generate a street address
            'add2' => $this->faker->optional()->secondaryAddress, // Optional secondary address
            'city' => $this->faker->city, // Generate a city
            'state' => $this->faker->stateAbbr, // Generate a state abbreviation
            'zip' => $this->faker->postcode, // Generate a postal code
            'website' => $this->faker->optional()->url, // Optional website URL
            'logo' => $this->faker->optional()->image('public/storage/logos', 150, 150, null, false), // Optional logo
        ];
    }
}
