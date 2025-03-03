<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::paginate(pagination_limit());
        return view('backend.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:coupons,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'discount' => 'required|integer',
            'min_purchase' => 'required|numeric',
            'max_discount' => 'required|numeric',
            'status' => 'required'
        ]);

        $coupon = new Coupon();
        $coupon->title = $request->title;
        $coupon->code = $request->code;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount = $request->discount;
        $coupon->min_purchase = $request->min_purchase;
        $coupon->max_discount = $request->max_discount;
        $coupon->status = $request->status;
        $coupon->save();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        return view('backend.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:coupons,code,'.$id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'discount' => 'required|integer',
            'min_purchase' => 'required|numeric',
            'max_discount' => 'required|numeric',
            'status' => 'required'
        ]);

        $coupon = Coupon::find($id);
        $coupon->title = $request->title;
        $coupon->code = $request->code;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount = $request->discount;
        $coupon->min_purchase = $request->min_purchase;
        $coupon->max_discount = $request->max_discount;
        $coupon->status = $request->status;
        $coupon->save();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully');
    }
}
