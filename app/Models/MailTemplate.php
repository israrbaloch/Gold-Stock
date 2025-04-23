<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model {
    use HasFactory;

    protected $fillable = [
        'subject',
        'template',
        'subscription',
    ];

    public function properties() {
        return $this->hasMany(MailTemplateProperty::class);
    }
}
