<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'team_strength' => $this->faker->numberBetween(50, 100),
            'home_strength' => $this->faker->numberBetween(0, 20),
            'away_strength' => $this->faker->numberBetween(0, 20),
        ];
    }
}
