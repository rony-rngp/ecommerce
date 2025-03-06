<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflinePaymentMethod extends Model
{
    protected $casts = [
        'method_fields' => 'array',
        'method_information' => 'array',
    ];
}
