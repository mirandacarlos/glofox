<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class LessonsWithBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lesson::factory(1)->has(Booking::factory(1)->state(
            function (array $attributes, Lesson $lesson) {
                return ['date' => $lesson->start];
            }
        ), 'bookings')->create();

        Lesson::factory(1)->has(Booking::factory(3)->state(
            function (array $attributes, Lesson $lesson) {
                return ['date' => $lesson->start];
            }
        ), 'bookings')->create();

        Lesson::factory(1)->has(Booking::factory(5)->state(
            function (array $attributes, Lesson $lesson) {
                return ['date' => $lesson->start];
            }
        ), 'bookings')->create();
    }
}
