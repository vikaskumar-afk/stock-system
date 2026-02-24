<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
class Subscription extends Model
{
    protected $fillable = ['name', 'recommendation_limit'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'subscription_id');
    }
}