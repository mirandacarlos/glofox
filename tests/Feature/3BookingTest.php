<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    /**
     * Get the bookings list.
     *
     * @return void
     */
    public function test_bookings_list()
    {
        $response = $this->getJson('/api/bookings/');
        $response->assertStatus(200)
            ->assertJsonCount(7);
    }

    /**
     * Get a booking detail.
     *
     * @return void
     */
    public function test_booking_detail()
    {
        $response = $this->getJson('/api/bookings/3');
        $response->assertStatus(200)
            ->assertJson(['id' => 3]);
    }

    /**
     * Booking detail not found.
     *
     * @return void
     */
    public function test_booking_detail_not_found()
    {
        $response = $this->getJson('/api/bookings/16');
        $response->assertStatus(404);
    }

    /**
     * Create booking.
     *
     * @return void
     */
    public function test_create_booking()
    {
        $booking = Booking::factory()->make();
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(201)
        ->assertJson($booking->attributesToArray());
    }

    /**
     * Booking class not found.
     *
     * @return void
     */
    public function test_booking_class_not_found()
    {
        $booking = Booking::factory()->make();
        $booking->lesson_id = 18;
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(404);
    }

    /**
     * Booking required field.
     *
     * @return void
     */
    public function test_required_field()
    {
        $booking = Booking::factory()->make();
        $booking->member_name = null;
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['member_name' => ['The member name field is required.']]);
    }

    /**
     * Class field type.
     *
     * @return void
     */
    public function test_field_type()
    {
        $booking = Booking::factory()->make();
        $booking->date = 3;
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(422);
    }

    /**
     * Invalid date before.
     *
     * @return void
     */
    public function test_invalid_date_before()
    {
        $lesson = Lesson::factory()->create([
            'start' => '2022-06-15',
            'end' => '2022-06-20'
        ]);
        $booking = Booking::factory()->make([
            'date' => '2022-06-14',
            'lesson_id' => $lesson->id
        ]);
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['date' => 
        ['The date must be a date after or equal to '.$lesson->start.'.']]);
    }

    /**
     * Invalid date after.
     *
     * @return void
     */
    public function test_invalid_date_after()
    {
        $lesson = Lesson::factory()->create([
            'start' => '2022-06-15',
            'end' => '2022-06-20'
        ]);
        $booking = Booking::factory()->make([
            'date' => '2022-06-23',
            'lesson_id' => $lesson->id
        ]);
        $response = $this->postJson(
            '/api/bookings',
            $booking->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['date' => 
        ['The date must be a date before or equal to '.$lesson->end.'.']]);
    }

    /**
     * Update booking.
     *
     * @return void
     */
    public function test_update_booking()
    {
        $booking = Booking::factory()->create();
        $booking->member_name = 'test member';
        $response = $this->putJson(
            '/api/bookings/'.$booking->id,
            $booking->attributesToArray()
        );
        $response->assertStatus(200)
        ->assertJsonFragment(['member_name' => 'test member']);
    }

    /**
     * Update invalid class.
     *
     * @return void
     */
    public function test_update_invalid_class()
    {
        $booking = Booking::factory()->create();
        $booking->lesson_id = 26;
        $response = $this->putJson(
            '/api/bookings/'.$booking->id,
            $booking->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(["lesson_id"=> 
        ["The selected lesson id is invalid."]]);
    }

    
}
