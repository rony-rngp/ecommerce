<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product.attributes')->where('user_id', Auth::user()->id)->get();
        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()){
            return response()->json(['status' => false, 'message' => 'For added wishlist. Please login your account']);
        }
        $product = Product::where(['status' => 1, 'id' => $request->product_id])->first();
        if ($product == null){
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        $check = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();
        if($check == null){
            $wishlist = new Wishlist();
            $wishlist->product_id = $request->product_id;
            $wishlist->user_id = Auth::user()->id;
            $wishlist->save();
            return response()->json(['status' => true, 'type' => 'add']);
        }else{
            $check->delete();
            return response()->json(['status' => true, 'type' => 'remove']);
        }

    }

    public function remove($id)
    {
        $id = Crypt::decrypt($id);
        $wishlist = Wishlist::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        $wishlist->delete();
        notify()->success('Item removed form wishlist');
        return redirect()->route('wishlist.index');
    }

}
