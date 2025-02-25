<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'title', 'video_url', 'pdf_notes'];

    // Define the relationship with module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
