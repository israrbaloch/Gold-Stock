<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionListUser extends Model {
    use HasFactory;

    protected $fillable = [
        'subscription_list_id',
        'user_id'
    ];

    public function subscriptionList() {
        return $this->belongsTo(SubscriptionList::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
