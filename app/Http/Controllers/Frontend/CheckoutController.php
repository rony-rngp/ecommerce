<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\OfflinePaymentMethod;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $carts = Session::get('cart', []);
        if (count($carts) == 0){
            notify()->error('Sorry, Your cart is empty');
            return redirect()->back();
        }
        foreach ($carts as $cart){
            $product = \App\Models\Product::where('status', 1)->where('id', $cart['product_id'])->first();
            $qty = $cart['qty'];
            if ($product != null) {
                if ($cart['attribute'] != '') {
                    $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)->where('attribute', $cart['attribute'])->first();
                    if($attribute == null){
                        notify()->error('Attribute not available.');
                        return redirect()->back();
                    }
                    if($attribute->stock == 0){
                        notify()->error('This '.$product->attribute_title.' is out of stock');
                        return redirect()->back();
                    }
                    if($attribute->stock < $qty){
                        notify()->error('Quantity is not available for this '.$product->attribute_title);
                        return redirect()->back();
                    }
                }else{
                    if($product->stock == 0){
                        notify()->error('This '.$product->name.' is out of stock');
                        return redirect()->back();
                    }
                    if($product->stock < $qty){
                        notify()->error('Quantity is not available for this '.$product->name);
                        return redirect()->back();
                    }
                }
            }else{
                notify()->error('Some product not available in your cart');
                return redirect()->back();
            }
        }
        $offline_payment_methods = OfflinePaymentMethod::where('status', 1)->get();
        return view('frontend.checkout.checkout', compact('carts', 'offline_payment_methods'));
    }

    public function checkout_store(Request $request)
    {
        $validate_array = [
            'name' => 'required',
            'phone' => 'required|min:9',
            'division' => 'required|in:Barishal,Chattogram,Dhaka,Khulna,Mymensingh,Rajshahi,Rangpur,Sylhet',
            'address' => 'required',
            'payment_method' => 'required',
        ];

        $request->validate($validate_array);

        $carts = Session::get('cart', []);
        if (count($carts) == 0) {
            throw ValidationException::withMessages(['error_msg' => 'Sorry, Your cart is empty']);
        }

        $grant_total = 0;

        foreach ($carts as $cart) {
            $product = \App\Models\Product::where('status', 1)->where('id', $cart['product_id'])->first();
            $qty = $cart['qty'];
            if ($product != null) {
                if ($cart['attribute'] != '') {
                    $has_attr = true;
                    $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)->where('attribute', $cart['attribute'])->first();
                    if ($attribute == null) {
                        throw ValidationException::withMessages(['error_msg' => 'Attribute not available.']);
                    }
                    if ($attribute->stock == 0) {
                        throw ValidationException::withMessages(['error_msg' => 'This ' . $product->attribute_title . ' is out of stock']);
                    }
                    if ($attribute->stock < $qty) {
                        throw ValidationException::withMessages(['error_msg' => 'Quantity is not available for this ' . $product->attribute_title]);
                    }

                    if ($product->discount > 0) {
                        $discount_amount = ($product->discount / 100) * @$attribute->price;
                        $discount_price = round(@$attribute->price - $discount_amount);
                    } else {
                        $discount_price = @$attribute->price;
                    }

                } else {
                    if ($product->stock == 0) {
                        throw ValidationException::withMessages(['error_msg' => 'This ' . $product->name . ' is out of stock']);
                    }
                    if ($product->stock < $qty) {
                        throw ValidationException::withMessages(['error_msg' => 'Quantity is not available for this ' . $product->name]);
                    }

                    if ($product->discount > 0) {
                        $discount_amount = ($product->discount / 100) * $product->price;
                        $discount_price = round($product->price - $discount_amount);
                    } else {
                        $discount_price = $product->price;
                    }
                }

                $grant_total += ($discount_price * $qty);

            } else {
                throw ValidationException::withMessages(['error_msg' => 'Some product not available in your cart']);
            }
        }

        $division = $request->division;
        if ($division == 'Dhaka') {
            $shipping_charge = get_settings('in_dhaka');
        } else {
            $shipping_charge = get_settings('outside_dhaka');
        }

        if(session()->has('coupon_code')){
            $coupon = Coupon::where('code', session()->get('coupon_code'))->where('status', 1)->first();
            if ($coupon == null){
                throw ValidationException::withMessages(['error_msg' => 'Invalid coupon code']);
            }
            $expiry_date = $coupon->end_date;
            $current_date = date('Y-m-d', strtotime(Carbon::now()));
            if($expiry_date < $current_date){
                throw ValidationException::withMessages(['error_msg' => 'This Coupon is expired!']);
            }
        }

        $coupon_discount = session()->has('coupon_code') ? session()->get('coupon_discount') : 0;

        $final_total = ($grant_total - $coupon_discount) + $shipping_charge;

        $offline_payment_info = [];

        if ($request->payment_method == 'cod') {
            $payment_method = 'cod';
            $payment_type = null;
        } else if ($request->payment_method == 'ssl_commerz') {
            $payment_method = 'SSLCOMMERZ';
            $payment_type = 'online';
        } else if ($request->payment_method == 'account_balance') {

            if (auth()->user()->balance < $final_total) {
                throw ValidationException::withMessages(['error_msg' => 'Your account balance is low. Please deposit first.']);
            }
            $payment_method = 'account_balance';
            $payment_type = null;
        } else {
            if (get_settings('offline_payment_status') != 1) {
                throw ValidationException::withMessages(['payment_method' => 'Offline method is disabled. please try another deposit method']);
            }
            $offline_payment_method = OfflinePaymentMethod::where('id', $request->payment_method)->first();
            if ($offline_payment_method == null) {
                throw ValidationException::withMessages(['payment_method' => 'Payment method not found']);
            }

            $validate_array = [];
            foreach ($offline_payment_method['method_information'] ?? [] as $method_information) {
                $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                $name = str_replace(' ', '_', $name_data);
                $name = strtolower($name);
                if ($method_information['input_filed_required'] == '1') {
                    $validate_array[strtolower($offline_payment_method['method_name']) . '_' . $name] = 'required';
                }
            }
            $request->validate($validate_array);


            foreach ($offline_payment_method['method_information'] ?? [] as $method_information) {
                $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                $name = str_replace(' ', '_', $name_data);
                $name = strtolower($name);

                $offline_payment_info[] = [
                    'key' => $method_information['input_filed_name'],
                    'value' => $request[strtolower($offline_payment_method['method_name']) . '_' . $name],
                ];
            }

            $payment_method = $offline_payment_method['method_name'];
            $payment_type = 'offline';

        }
        $shipping_info = [
            'name' => $request->name,
            'phone' => $request->phone,
            'division' => $division,
            'address' => $request->address,
        ];

        try {

            DB::transaction(function () use ($carts, $final_total, $grant_total, $division, $request, $shipping_charge, $shipping_info,
                $payment_type, $payment_method, $offline_payment_info, &$order) {

                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->shipping_type = $division == 'Dhaka' ? 'In Dhaka' : 'Outside Dhaka';
                $order->shipping_info = $shipping_info;
                $order->payment_type = $payment_type;
                $order->payment_method = $payment_method;
                if ($payment_type == 'offline') {
                    $order->offline_payment_info = $offline_payment_info;
                }
                if (session()->has('coupon_code')) {
                    $order->coupon_code = session()->get('coupon_code');
                    $order->coupon_discount = session()->get('coupon_discount');
                }
                $order->subtotal = $grant_total;
                $order->shipping_charge = $shipping_charge;
                $order->grand_total = $final_total;
                if ($request->payment_method == 'account_balance'){
                    $order->payment_status = 1;
                }else{
                    $order->payment_status = 0;
                }
                $order->status = 'Pending';
                $order->save();

                foreach ($carts ?? [] as $cart) {
                    $product = \App\Models\Product::where('status', 1)->where('id', $cart['product_id'])->first();
                    $qty = $cart['qty'];
                    if ($product != null) {

                        if ($cart['attribute'] != '') {
                            $has_attribute = true;
                            $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)->where('attribute', $cart['attribute'])->first();
                            if ($product->discount > 0) {
                                $discount_amount = ($product->discount / 100) * @$attribute->price;
                                $discount_price = round(@$attribute->price - $discount_amount);
                            } else {
                                $discount_price = @$attribute->price;
                            }

                            //reduse stock
                            $attribute->stock = $attribute->stock - $qty;
                            $attribute->update();

                        } else {
                            $has_attribute = false;
                            if ($product->discount > 0) {
                                $discount_amount = ($product->discount / 100) * $product->price;
                                $discount_price = round($product->price - $discount_amount);
                            } else {
                                $discount_price = $product->price;
                            }

                            //reduse stock
                            $product->stock = $product->stock - $qty;
                            $product->update();
                        }

                        $order_product = new OrderProduct();
                        $order_product->order_id = $order->id;
                        $order_product->product_id = $product->id;
                        $order_product->product_name = $product->name;
                        $order_product->product_sku = $product->sku;
                        $order_product->has_attribute = $product->has_attribute;
                        $order_product->attribute_title = $product->attribute_title;
                        $order_product->product_attribute = $has_attribute ? $attribute['attribute'] : null;
                        $order_product->product_color = $cart['color_name'];
                        $order_product->product_price = $discount_price;
                        $order_product->product_qty = $cart['qty'];
                        $order_product->save();

                    }
                }

                if ($request->payment_method == 'account_balance'){
                    $user = User::find(Auth::user()->id);
                    $user->balance = $user->balance - $final_total;
                    $user->update();

                    placeOrderLog($order);

                }

            });

            Session::forget('cart');
            Session::forget('coupon_code');
            Session::forget('coupon_discount');

            return response()->json(['result'=>'success','payment_method'=> $payment_method, 'order_id' => $order->id, 'encrypt' => Crypt::encrypt($order->id)]);

        }catch (\Exception $exception){
            throw ValidationException::withMessages(['error_msg' => $exception->getMessage()]);
        }

    }

    public function order_complete(Request $request)
    {
        if ($request['query'] != ''){
            $order_id = base64_decode($request['query']);
            $order = Order::with('order_details')->where('user_id', Auth::user()->id)->where('id', $order_id)->first();
            if ($order == null){
                notify()->error('Order not found');
                return redirect('/');
            }
            return view('frontend.checkout.order_complete', compact('order'));
        }else{
            notify()->error('Something went to wrong');
            return redirect('/');
        }
    }

}
