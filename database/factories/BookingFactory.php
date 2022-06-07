<?php

namespace Database\Factories;

use App\Models\Classes;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('now', '+1 month');
        $class = Classes::where('start', '<=', $start)->where('end', '>=', $start)->first();
        if (is_null($class)) {
            $class = Classes::factory(1)->create([
                'start' => $start,
                'end' => $this->faker->dateTimeBetween($start, '+1 month')
            ])[0];
        }

        return [
            'member_name' => $this->faker->name(),
            'date' => $start,
            'class_id' => $class->id
        ];
    }
}
