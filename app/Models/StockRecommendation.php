<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRecommendation extends Model
{
    protected $fillable = ['stock_id', 'subscription_id', 'customer_id'];
}
