<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Get the class that owns the book.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
