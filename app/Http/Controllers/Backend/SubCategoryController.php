<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::paginate(pagination_limit());
        return view('backend.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|unique:subcategories,name',
            'slug' => 'required|unique:subcategories,slug',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $subcategory = new Subcategory();
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        if($request->has('image')){
            $subcategory->image = upload_image('subcategory/', $request->file('image'));
        }
        $subcategory->save();

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully!');
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
        $subcategory = Subcategory::find($id);
        $categories = Category::get();
        return view('backend.subcategory.edit', compact('categories', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|unique:subcategories,name,'.$id,
            'slug' => 'required|unique:subcategories,slug,'.$id,
            'status' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $subcategory = Subcategory::find($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        if($request->has('image')){
            $subcategory->image = update_image('subcategory/', $subcategory->image, $request->file('image'));
        }
        $subcategory->save();

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = Subcategory::find($id);
        delete_image($subcategory->image);
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted successfully!');
    }
}
