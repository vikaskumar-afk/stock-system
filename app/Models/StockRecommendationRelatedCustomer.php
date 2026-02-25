<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRecommendationRelatedCustomer extends Model
{
    protected $table = 'recommend_customers';
    protected $fillable = ['stock_recommend_id', 'customer_id'];
}
