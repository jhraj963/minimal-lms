<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'module_number'];

    // Define the relationship with lectures
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    // Define the relationship with course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
