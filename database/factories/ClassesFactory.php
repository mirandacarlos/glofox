<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_date = $this->faker->dateTimeBetween('now', '+1 month');
        return [
            'name' => $this->faker->words(3, true),
            'start' => $start_date,
            'end' => $this->faker->dateTimeBetween($start_date, '+1 month'),
            'capacity' => $this->faker->randomNumber(2)
        ];
    }
}
