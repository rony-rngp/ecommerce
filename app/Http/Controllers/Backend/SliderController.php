<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::with('product:id,name', 'category:id,name')->paginate(pagination_limit());
        return view('backend.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('backend.slider.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'first_title' => 'required',
           'type' => 'required',
           'product_id' => 'required_if:type,product_id',
           'category_id' => 'required_if:type,category_id',
           'background_image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048',
           'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048',
        ]);

        $slider = new Slider();
        $slider->first_title = $request->first_title;
        $slider->second_title = $request->second_title;
        $slider->third_title = $request->third_title;
        $slider->type = $request->type;
        if($request->type == 'product'){
            $slider->product_id = $request->product_id;
        }else{
            $slider->category_id = $request->category_id;
        }
        if($request->has('background_image')){
            $slider->background_image = upload_image('slider/', $request->file('background_image'));
        }
        if($request->has('image')){
            $slider->image = upload_image('slider/', $request->file('image'));
        }
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully!');
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
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $slider = Slider::find($id);
        return view('backend.slider.edit', compact('categories', 'products', 'slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_title' => 'required',
            'type' => 'required',
            'product_id' => 'required_if:type,product_id',
            'category_id' => 'required_if:type,category_id',
            'background_image' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
            'image' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
        ]);

        $slider = Slider::find($id);
        $slider->first_title = $request->first_title;
        $slider->second_title = $request->second_title;
        $slider->third_title = $request->third_title;
        $slider->type = $request->type;
        if($request->type == 'product'){
            $slider->product_id = $request->product_id;
            $slider->category_id = null;
        }else{
            $slider->category_id = $request->category_id;
            $slider->product_id = null;
        }
        if($request->has('background_image')){
            $slider->background_image = update_image('slider/', $slider->background_image, $request->file('background_image'));
        }
        if($request->has('image')){
            $slider->image = update_image('slider/', $slider->image, $request->file('image'));
        }
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        delete_image($slider->background_image);
        delete_image($slider->image);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully!');
    }
}
