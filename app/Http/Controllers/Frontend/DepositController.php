<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\OfflinePaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function deposit_list()
    {
        $deposits = Deposit::where('user_id', Auth::user()->id)->latest()->get();
        $offline_payment_methods = OfflinePaymentMethod::where('status', 1)->get();
        return view('frontend.user.deposit.deposit_list', compact('deposits', 'offline_payment_methods'));
    }
}
