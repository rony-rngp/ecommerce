<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    protected $casts = [
        'method_information' => 'array',
    ];
}
