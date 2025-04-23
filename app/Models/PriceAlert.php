<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
    use HasFactory;

    protected $dates = ['last_sent_at'];

    // guarded none
    protected $guarded = [];

    // belongsTo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // belongsTo Metal
    public function metal()
    {
        return $this->belongsTo(Metal::class);
    }

    // belongsTo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
