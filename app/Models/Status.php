<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Status extends Model {
    protected $table = "statuses";

    public function scopeTransaction($query) {
        return $query->where('type', 'transaction');
    }
    public function scopeShipping($query) {
        return $query->where('type', 'shipping');
    }
}
