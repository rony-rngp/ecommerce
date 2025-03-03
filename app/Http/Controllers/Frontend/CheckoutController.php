<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $carts = Session::get('cart', []);
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

        dd('ok');
    }
}
