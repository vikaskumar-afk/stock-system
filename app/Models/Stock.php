<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['stock_name', 'stock_listing', 'subscription_id'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
