<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplateProperty extends Model {
    use HasFactory;

    protected $fillable = [
        'mail_template_id',
        'type',
        'is_required',
        'status',
    ];

    public function mailTemplate() {
        return $this->belongsTo(MailTemplate::class);
    }
}
