<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(pagination_limit());
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:categories,name',
           'slug' => 'required|unique:categories,slug',
           'icon' => 'required',
           'status' => 'required',
           'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->icon = $request->icon;
        $category->status = $request->status;
        if($request->has('image')){
            $category->image = upload_image('category/', $request->file('image'));
        }
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
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
        $category = Category::find($id);
        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'slug' => 'required|unique:categories,slug,'.$id,
            'icon' => 'required',
            'status' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->icon = $request->icon;
        $category->status = $request->status;
        if($request->has('image')){
            $category->image = update_image('category/', $category->image, $request->file('image'));
        }
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        delete_image($category->image);
        $category->delete();

        $subcategories = Subcategory::where('category_id', $category->id)->get();
        foreach ($subcategories as $subcategory){
            $subcategory->delete();
            delete_image($subcategory->image);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');

    }
}
