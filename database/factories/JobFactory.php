<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle, // Generate realistic job titles
            'content' => $this->faker->paragraph(3), // Generate a short description
            'estimate' => $this->faker->randomFloat(2, 500, 10000), // Generate realistic estimates
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random date within the last year
            'updated_at' => now(),
        ];
    }
}
