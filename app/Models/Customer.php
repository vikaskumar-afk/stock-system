<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_id',
        'remaining_recommendations',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function recommendations()
    {
        return $this->belongsToMany(StockRecommendation::class, 'recommend_customers', 'customer_id', 'stock_recommend_id')
            ->withTimestamps();
    }
}