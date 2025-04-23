<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HTModel extends Model {
    use HasFactory;

    protected $primaryKey = 'timestamp_id';
    public $timestamps = false;

    protected $fillable = [
        'timestamp_id',
        'open',
        'high',
        'low',
        'close',
        'market_open'
    ];

    protected $casts = [
        'market_open' => 'boolean'
    ];
}
