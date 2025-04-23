<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image', 'button_text', 'button_link', 'start_date', 'end_date', 'status', 'position','type', 'alignment', 'mobile_image'
    ];

    // Check if banner is active based on schedule
    public function isActive()
    {
        $now = now();
        return ($this->status == 1) && (!$this->start_date || $this->start_date <= $now) && (!$this->end_date || $this->end_date >= $now);
    }


    // cast status to boolean
    protected $casts = [
        'status' => 'boolean',
    ];
}
