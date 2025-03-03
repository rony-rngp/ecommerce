<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $data['sliders'] = Slider::get();
        $data['new_arrivals'] = Product::where('status', 1)->latest()->take(10)->get();
        return view('frontend.home', $data);
    }

    public function product_details($slug)
    {
        $product = Product::with('category', 'subcategory', 'brand', 'attributes', 'product_colors', 'product_galleries')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
        return view('frontend.product.product_details', compact('product'));
    }

    public function add_to_card(Request $request, $id)
    {

        Session::forget('coupon_code');
        Session::forget('coupon_discount');

       $product = Product::where('id', $id)->where('status', 1)->firstOrFail();

        $request->validate([
            'attribute' => $product->has_attribute == 1 ? 'required' : 'nullable',
            'color_name' => count($product->product_colors) > 0 ? 'required' : 'nullable',
            'quantity' => 'required|min:1',
        ]);

        $qty = $request->quantity;

        $attribute = null;

        if($product->has_attribute == 1){
            $attribute = ProductAttribute::where('product_id', $product->id)->where('attribute', $request->attribute)->first();
            if(!$attribute){
                notify()->error('Attribute not found');
                return redirect()->back();
            }
            if($attribute->stock < 1){
                notify()->error('Sorry ! This Product is out of stock!');
                return redirect()->back();
            }
            if($attribute->stock < $qty){
                notify()->error('Sorry ! Required Quantity is not available!');
                return redirect()->back();
            }
        }else{
            if($product->stock < 1){
                notify()->error('Sorry ! This Product is out of stock!');
                return redirect()->back();
            }
            if($product->stock < $qty){
                notify()->error('Sorry ! Required Quantity is not available!');
                return redirect()->back();
            }
        }

        $color_name = null;
        if(count($product->product_colors) > 0){
            $color = Color::where('color_name', $request->color_name)->first();
            if(!$color){
                notify()->error('Sorry ! Color not found');
                return redirect()->back();
            }
            $color_name = $color->color_name;
        }

        $cart = Session::get('cart', []);
        $check = collect($cart)->where('product_id',$product->id)
            ->where('attribute', $request->attribute)
            ->where('color_name', $request->color_name)
            ->count();

        if($check > 0){
            notify()->error('Sorry ! Product already exists in Cart!');
            return redirect()->back();
        }

        $data = [
            'product_id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'attribute' => $request->attribute,
            'color_name' => $color_name,
            'qty' => $qty
        ];

        $cart[] = $data;

        Session::put('cart', $cart);

        notify()->success('Product has been added in cart');
        return redirect()->back();
    }

    public function view_cart()
    {
        $carts = Session::get('cart', []);
        return view('frontend.cart.cart_list', compact('carts'));
    }

    public function update_qty(Request $request)
    {
        $key = $request->key;

        $cart = Session::get('cart', []);

        if (isset($cart[$key])) {

            Session::forget('coupon_code');
            Session::forget('coupon_discount');

            if ($request->type == 'add'){
                $qty = $cart[$key]['qty'] + 1;
            }else{
                $qty = $cart[$key]['qty'] - 1;
            }


            $item = $cart[$key];
            $product = Product::find($item['product_id']);

            if($item['qty'] == 1 && $request->type != 'add'){
                return response()->json(['status' => false, 'message' => 'Sorry, Current quantity 1']);
            }

            if ($item['attribute'] != ''){
                $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)
                    ->where('attribute', $item['attribute'])->first();
                if($attribute->stock < $qty){
                    return response()->json(['status' => false, 'message' => 'Sorry ! Required Quantity is not available!']);
                }
            }else{
                if($product->stock < $qty){
                    return response()->json(['status' => false, 'message' => 'Sorry ! Required Quantity is not available!']);
                }
            }
            $cart[$key]['qty'] = $qty;
            Session::put('cart', $cart);
            return response()->json(['status' => true, 'message' => 'Quantity successfully updated']);
        } else {
            return response()->json(['status' => false, 'message' => 'Sorry, Item not found']);
        }

    }

    public function remove_item_cart($key)
    {
        $cart = Session::get('cart', []);

        // Check if index exists
        if (isset($cart[$key])) {
            unset($cart[$key]); // Remove the item at the given index
            Session::put('cart', array_values($cart)); // Re-index array
        }

        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        notify()->success('Item removed from cart');
        return redirect()->back();
    }

    public function clear_cart()
    {
        Session::forget('cart');

        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        notify()->success('Cart cleared successfully');
        return redirect()->back();
    }

    public function apply_coupon(Request $request)
    {
        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        $code = $request->coupon;
        if ($code == ''){
            return response()->json(['status' => false, 'message' => 'Coupon filed is required']);
        }

        $coupon = Coupon::where('code', $code)->where('status', 1)->first();
        if ($coupon == null){
            return response()->json(['status' => false, 'message' => 'Invalid coupon code']);
        }
        $expiry_date = $coupon->end_date;
        $current_date = date('Y-m-d', strtotime(Carbon::now()));
        if($expiry_date < $current_date){
            return response()->json(['status' => false, 'message' => 'This Coupon is expired!']);
        }

        //check max 1 order..


        $carts = Session::get('cart', []);

        $grant_total = 0;

        foreach ($carts as $cart){
            $product = \App\Models\Product::where('status', 1)->where('id', $cart['product_id'])->first();
            if ($product != null) {
                $has_attr = false;
                $attribute = null;
                if ($cart['attribute'] != '') {
                    $has_attr = true;
                    $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)
                        ->where('attribute', $cart['attribute'])->first();
                    if($attribute == null){
                        return response()->json(['status' => false, 'message' => 'Attribute not available.']);
                    }
                }
                $qty = $cart['qty'];
                if ($has_attr) {
                    if ($product->discount > 0) {
                        $discount_amount = ($product->discount / 100) * @$attribute->price;
                        $discount_amount = round($discount_amount);
                        $discount_price = round(@$attribute->price - $discount_amount);
                    } else {
                        $discount_price = @$attribute->price;
                    }
                } else {
                    if ($product->discount > 0) {
                        $discount_amount = ($product->discount / 100) * $product->price;
                        $discount_amount = round($discount_amount);
                        $discount_price = round($product->price - $discount_amount);
                    } else {
                        $discount_price = $product->price;
                    }
                }
                $grant_total += ($discount_price*$qty);
            }else{
                return response()->json(['status' => false, 'message' => 'Some product not available in your cart']);
            }
        }

        if ($grant_total < $coupon->min_purchase){
            return response()->json(['status' => false, 'message' => 'This coupon requires a minimum purchase of ' . base_currency().$coupon->min_purchase . ' to be applied.']);
        }

        $discount = $coupon->discount;
        $discount_amount = ($discount/100)*$grant_total;
        $total_discount_amount = 0;
        //check max discount
        $max_discount = $coupon->max_discount;
        if($max_discount > $discount_amount){
            $total_discount_amount = $discount_amount;
        }else{
            $total_discount_amount = $max_discount;
        }
        $total_discount_amount = round($total_discount_amount);

        Session::put('coupon_code', $coupon->code);
        Session::put('coupon_discount', $total_discount_amount);

        return response(['status' => true, 'message' => 'Coupon successfully applied']);

    }

    public function remove_coupon()
    {
        Session::forget('coupon_code');
        Session::forget('coupon_discount');
        notify()->success('Coupon removed successfully');
        return redirect()->back();
    }

}
