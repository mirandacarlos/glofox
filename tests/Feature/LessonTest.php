<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Lesson;
use DateInterval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonTest extends TestCase
{
    /**
     * Get the classes list.
     *
     * @return void
     */
    public function test_classes_list()
    {
        $response = $this->getJson('/api/classes/');
        $response->assertStatus(200)
        ->assertJsonCount(6);
    }

    /**
     * Get a class detail.
     *
     * @return void
     */
    public function test_class_detail()
    {
        $response = $this->getJson('/api/classes/3');
        $response->assertStatus(200)
        ->assertJson(['id' => 3]);
    }

    /**
     * Class detail not found.
     *
     * @return void
     */
    public function test_class_detail_not_found()
    {
        $response = $this->getJson('/api/classes/30');
        $response->assertStatus(404);
    }

    /**
     * Create new class.
     *
     * @return void
     */
    public function test_create_class()
    {
        $lesson = Lesson::factory()->make([
            'name' => 'create class test',
            'start' => '2022-06-12',
            'end' => '2022-06-18',
            'capacity' => 15
        ]);
        $response = $this->postJson(
            '/api/classes',
            $lesson->attributesToArray()
        );
        $response->assertStatus(201)
        ->assertJson($lesson->attributesToArray());
    }

    /**
     * Class required field.
     *
     * @return void
     */
    public function test_required_field()
    {
        $lesson = Lesson::factory()->make();
        $lesson->capacity = null;
        $response = $this->postJson(
            '/api/classes',
            $lesson->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['capacity' => ['The capacity field is required.']]);
    }

    /**
     * Class field type.
     *
     * @return void
     */
    public function test_field_type()
    {
        $lesson = Lesson::factory()->make();
        $lesson->start = 3;
        $response = $this->postJson(
            '/api/classes',
            $lesson->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['start' => ['The start is not a valid date.']]);
    }

    /**
     * Class end date.
     *
     * @return void
     */
    public function test_end_date()
    {
        $lesson = Lesson::factory()->make();
        $aux = $lesson->start;
        $lesson->start = strtotime($lesson->end->format('Y-m-d').' +1 day');
        $lesson->end = $aux->format('Y-m-d');
        $response = $this->postJson(
            '/api/classes',
            $lesson->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['end' => ['The end must be a date after or equal to start.']]);
    }

    /**
     * Update class.
     *
     * @return void
     */
    public function test_update_class()
    {
        $lesson = Lesson::factory()->create();
        $lesson->name = 'this is a test';
        $lesson->start = $lesson->start->format('Y-m-d');
        $lesson->end = $lesson->end->format('Y-m-d');
        $response = $this->putJson(
            '/api/classes/'.$lesson->id,
            $lesson->attributesToArray()
        );
        $response->assertStatus(200)
        ->assertJson($lesson->attributesToArray());
    }

    /**
     * Validation on class update.
     *
     * @return void
     */
    public function test_update_validation()
    {
        $lesson = Lesson::factory()->create();
        $aux = $lesson->start->format('Y-m-d');
        $lesson->start = $lesson->end->format('y-m-d');
        $lesson->end = $aux;
        $response = $this->putJson(
            '/api/classes/'.$lesson->id,
            $lesson->attributesToArray()
        );
        $response->assertStatus(422)
        ->assertJsonFragment(['end' => ['The end must be a date after or equal to start.']]);
    }

    /**
     * Update class not found.
     *
     * @return void
     */
    public function test_update_not_found()
    {
        $lesson = Lesson::factory()->make();
        $lesson->start = $lesson->start->format('y-m-d');
        $lesson->end = $lesson->end->format('Y-m-d');
        $response = $this->putJson(
            '/api/classes/46',
            $lesson->attributesToArray()
        );
        $response->assertStatus(404);
    }

    /**
     * Delete class not found.
     *
     * @return void
     */
    public function test_delete_not_found()
    {
        $response = $this->deleteJson('/api/classes/57');
        $response->assertStatus(404);
    }

    /**
     * Delete class.
     *
     * @return void
     */
    public function test_delete_class()
    {
        $lesson = Lesson::factory()->create();
        $response = $this->deleteJson('/api/classes/'.$lesson->id);
        $response->assertStatus(204);
    }

    /**
     * Delete class with bookings.
     *
     * @return void
     */
    public function test_delete_class_with_bookings()
    {
        $booking = Booking::factory()->create();
        $response = $this->deleteJson('/api/classes/'.$booking->lesson_id);
        $response->assertStatus(422)
        ->assertJson(['error' => 'the class have bookings associated']);
    }
}
