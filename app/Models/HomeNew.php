<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeNew extends Model {
    use HasFactory;
    protected $table = "home_news";

    protected $fillable = [
        'title',
        'description',
        // 'url',
        'image',
        'author',
        'disabled',
        'date',
        // 'timestamp',
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
