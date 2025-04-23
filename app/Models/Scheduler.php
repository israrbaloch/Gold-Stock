<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model {
    use HasFactory;

    protected $fillable = [
        'template_id',
        'scheduled_at',
        'type',
        'subscription_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function users() {
        return $this->belongsToMany(SchedulerUser::class);
    }

    public function template() {
        return $this->belongsTo(MailTemplate::class);
    }

    public function selectedUsers() {
        return $this->belongsToMany(User::class, 'scheduler_selected_users');
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

    public function send() {
        $this->users->each(function ($user) {
            $user->sendMail($this);
        });
    }
}
