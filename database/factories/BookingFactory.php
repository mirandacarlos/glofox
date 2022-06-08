<?php

namespace Database\Factories;

use App\Models\Lesson;
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
        $lesson = null;
        $lessons = Lesson::all();
        $lesson = $lessons->isEmpty() ?
            Lesson::factory()->create() :
            $lessons->random();
        return [
            'lesson_id' => $lesson,
            'member_name' => $this->faker->name(),
            'date' => function () use ($lesson) {
                return $this->faker->dateTimeBetween($lesson->start, $lesson->end);
            }
        ];
    }
}
