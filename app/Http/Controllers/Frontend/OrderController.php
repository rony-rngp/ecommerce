<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function order_list()
    {
        $orders = Order::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.user.order.order_list', compact('orders'));
    }

    public function order_details($id)
    {
        $id = Crypt::decrypt($id);
        $order = Order::with('order_details')->where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        return view('frontend.user.order.order_details', compact('order'));
    }
}
