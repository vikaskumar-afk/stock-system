<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['name', 'recommendation_limit'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}