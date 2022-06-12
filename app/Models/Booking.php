<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['member_name', 'date', 'lesson_id'];

    /**
     * Get the class that owns the booking.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
