<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulerSelectedUser extends Model {
    use HasFactory;

    protected $fillable = ['scheduler_id', 'user_id', 'sent'];

    protected $casts = [
        'sent' => 'boolean',
    ];

    public function scheduler() {
        return $this->belongsTo(Scheduler::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function markAsSent() {
        $this->sent = true;
        $this->save();
    }

    public function markAsUnsent() {
        $this->sent = false;
        $this->save();
    }

    public function isSent() {
        return $this->sent;
    }
}
