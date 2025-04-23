<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'gold',
        'silver',
        'platinum',
        'palladium',
    ];
}
