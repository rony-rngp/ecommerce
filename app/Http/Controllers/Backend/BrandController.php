<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(pagination_limit());
        return view('backend.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'slug' => 'required|unique:brands,slug',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        if($request->has('image')){
            $brand->image = upload_image('brand/', $request->file('image'));
        }
        $brand->save();
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
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
        $brand = Brand::find($id);
        return view('backend.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,'.$id,
            'slug' => 'required|unique:brands,slug,'.$id,
            'status' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        if($request->has('image')){
            $brand->image = update_image('brand/', $brand->image, $request->file('image'));
        }
        $brand->save();
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        delete_image($brand->image);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }
}
