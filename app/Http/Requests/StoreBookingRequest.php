<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $lesson = Lesson::findOrFail($this->lesson_id);
        return [
            'member_name' => 'required|string',
            'date' => 'required|date|before_or_equal:'
            .$lesson->end.'|after_or_equal:'.$lesson->start,
            'lesson_id' => 'required|integer|exists:lessons,id'
        ];
    }
}
