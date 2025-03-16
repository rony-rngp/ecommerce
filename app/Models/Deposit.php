<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $casts = [
        'offline_payment_info' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
