<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model {
    use HasFactory;

    protected $table = "blogs";

    protected $fillable = [
        'title',
        'description',
        'image',
        'disabled',
        'date',
    ];

    // Casts
    protected $casts = [
        'disabled' => 'boolean',
        'date' => 'datetime',
        'timestamp' => 'datetime',
    ];

    // Accessor
    public function getTimestampAttribute($value) {
        return Carbon::parse($value);
    }
}
