<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $casts = [
        'withdraw_method_information' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
