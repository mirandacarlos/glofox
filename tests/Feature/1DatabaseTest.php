<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Lesson;
use Database\Seeders\LessonsSeeder;
use Database\Seeders\BookingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * Start empty database
     *
     * @return void
     */
    public function test_database_migration()
    {
        $this->artisan('migrate:fresh --path=database/migrations/glofox')
            ->assertSuccessful();
    }

    /**
     * Lesson can be instantiate.
     *
     * @return void
     */
    public function test_instantiate_lesson()
    {
        $class = Lesson::factory()->make();
        $this->assertInstanceOf(Lesson::class, $class);
    }

    /**
     * Create test lessons.
     *
     * @return void
     */
    public function test_lessons_seeder()
    {
        $this->seed(LessonsSeeder::class);
        $this->assertCount(5, Lesson::all());
    }

    /**
     * Booking can be instantiate.
     *
     * @return void
     */
    public function test_instantiate_booking()
    {
        $booking = Booking::factory()->make();
        $this->assertInstanceOf(Booking::class, $booking);
    }    

    /**
     * Create test bookings.
     *
     * @return void
     */
    public function test_bookings_seeder()
    {
        $this->seed(BookingsSeeder::class);
        $this->assertCount(5, Booking::all());
    }

    /**
     * Lesson exist.
     *
     * @return void
     */
    public function test_lesson_exist()
    {
        $lesson = Lesson::factory()->create();
        $this->assertModelExists($lesson);
    }

    /**
     * Booking exist.
     *
     * @return void
     */
    public function test_booking_exist()
    {
        $booking = Booking::factory()->create();
        $this->assertModelExists($booking);
    }
}