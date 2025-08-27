<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->text(200),
            'start_time' => fake()->dateTimeBetween('now', '+1 weeks'),
            'end_time' => fake()->dateTimeBetween('+2 weeks', '+4 weeks')
        ];
    }
}
