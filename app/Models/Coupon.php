<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function scopeActive($query)
    {
        return $query->where(['status' => 1])->where('start_date', '<=', now()->format('Y-m-d'))->where('end_date', '>=', now()->format('Y-m-d'));
    }
}
