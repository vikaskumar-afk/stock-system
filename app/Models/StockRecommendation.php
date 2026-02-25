<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Subscription;
use App\Models\Customer;

class StockRecommendation extends Model
{
    protected $table = 'stock_recommends';
    protected $fillable = ['stock_id', 'subscription_id'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'recommend_customers', 'stock_recommend_id', 'customer_id')
            ->withTimestamps();
    }
}
