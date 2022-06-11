<?php

namespace Tests\Feature;

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
}
