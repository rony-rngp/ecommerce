<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->flash();
        $orders = Order::with('user');
        if ($request->email){
            $user = User::where('email', $request->email)->first(['id']);
            $orders = $orders->where('user_id', $user->id);
        }
        if ($request->status){
            $orders = $orders->where('status', $request->status);
        }
        $orders = $orders->latest()->paginate(pagination_limit());
        return view('backend.order.index', compact('orders'));
    }

    public function details($id)
    {
        $order = Order::with('user', 'order_details')->find($id);
        $order->is_seen = 1;
        $order->update();

        return view('backend.order.order_details', compact('order'));
    }

    public function update_status($id, Request $request)
    {
        $order = Order::find($id);
        $status = $request->status;

        if ($order->status == $status){
            return redirect()->back()->with('error', 'You can not update same status');
        }

        if (in_array($order->status, ['Delivered', 'Failed', 'Cancelled'])) {
            return redirect()->back()->with('error', 'You can not change the status of '.$status.' order');
        }

        if ($order->payment_type == 'offline' && $order->payment_status == 0 && !in_array($status, ['Failed', 'Cancelled'])){
            return redirect()->back()->with('error', 'Your offline payment status is unpaid. Please update it to paid');
        }

        if ($status == 'Delivered'){
            if (get_settings('allow_refer_income') == 1){
                $user = User::find($order->user_id);
                $refer_by = $user->refer_by;
                if($refer_by != null){
                    addReferEarning($order, $refer_by);
                }
            }

            if ($order->payment_method == 'cod'){
                $order->payment_status = 1;
            }

        }

        if (in_array($status, ['Failed', 'Cancelled'])) {

            $order_details = OrderProduct::where('order_id', $order->id)->get();
            foreach ($order_details as $order_detail){
                if ($order_detail->has_attribute == 1){
                    $attribute = ProductAttribute::where('product_id', $order_detail->product_id)
                        ->where('attribute', $order_detail->product_attribute)
                        ->first();
                    if ($attribute != null){
                        $attribute->stock = $attribute->stock+$order_detail->product_qty;
                        $attribute->update();
                    }
                }else{
                    $product = Product::find($order_detail->product_id);
                    if ($product != null){
                        $product->stock = $product->stock+$order_detail->product_qty;
                        $product->update();
                    }
                }
            }

        }

        $order->status = $status;
        $order->update();

        return redirect()->back()->with('success', 'Order status has been update');

    }

    public function update_payment_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->payment_status = $request->payment_status;
        $order->update();
        return response()->json(['message' => 'payment status updated to '.$request->payment_status]);
    }

}
