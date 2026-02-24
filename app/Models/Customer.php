<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_id',
        'remaining_recommendations',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
