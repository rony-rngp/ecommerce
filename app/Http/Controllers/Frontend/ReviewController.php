<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function my_reviews()
    {
        $reviews = ProductReview::with('product')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.user.review.my_review', compact('reviews'));
    }

    public function review_details($id)
    {
        $id = Crypt::decrypt($id);
        $product_review = ProductReview::with('product')->find($id);
        return view('frontend.user.review.review_details', compact('product_review'));
    }

    public function store_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ratings' => 'required|min:1|max:5',
            'order_id' => 'required|integer',
            'product_id' => 'required',
            'review' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error('Something went to wrong');
            return redirect()->back();
        }
        $product_id = Crypt::decrypt($request->product_id);
        $product = Product::find($product_id);
        if ($product == null){
            notify()->error('Product not found');
            return redirect()->back();
        }

        $check_order = Order::where('user_id', Auth::user()->id)->where('id', $request->order_id)->count();
        if ($check_order == 0){
            notify()->error('Order not found');
            return redirect()->back();
        }

        $check_review = ProductReview::where('user_id', Auth::user()->id)->where('product_id', $product_id)->where('order_id', $request->order_id)->count();
        if ($check_review > 0){
            notify()->error('You have already reviewed this product');
            return redirect()->back();
        }

        $product_review = new ProductReview();
        $product_review->product_id = $product->id;
        $product_review->user_id = Auth::user()->id;
        $product_review->order_id = $request->order_id;
        $product_review->rating = $request->ratings;
        $product_review->review = $request->review;
        $product_review->save();

        notify()->success('Review added successfully');
        return redirect()->back();

    }
}
