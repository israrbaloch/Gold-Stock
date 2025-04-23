<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'verified',
        'file',
    ];

    public function getFileAttribute($value) {
        return $value ? url('storage/' . $value) : null;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
