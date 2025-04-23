<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ShippingOption extends Model {

    protected $table = "shipping_options";

    protected $fillable = [
        'name',
        'description',
        'price',
        'free_from',
        'show_address',
    ];

    protected $hidden = [
        'show_address',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'price' => 'float',
        'free_from' => 'float',
        'show_address' => 'boolean'
    ];

    public function scopeByadmin($query) {
        return $query->where('id', 2)->orWhere('id', 3);
    }
}
