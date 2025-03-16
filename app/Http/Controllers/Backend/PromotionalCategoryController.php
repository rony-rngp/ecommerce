<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PromotionalCategory;
use Illuminate\Http\Request;

class PromotionalCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotional_categories = PromotionalCategory::with('category')->get();
        return view('backend.promotional_category.index', compact('promotional_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (PromotionalCategory::count() >= 2){
            return redirect()->route('admin.promotional-categories.index')->with('error', "Max added limit 2 item");

        }
        $categories = Category::where('status', 1)->get();
        return view('backend.promotional_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'subtitle' => 'required',
           'category_id' => 'required|integer',
           'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048',
        ]);

        $promotional_category = new PromotionalCategory();
        $promotional_category->title = $request->title;
        $promotional_category->subtitle = $request->subtitle;
        $promotional_category->category_id = $request->category_id;
        if($request->has('image')){
            $promotional_category->image = upload_image('promotional_cat/', $request->file('image'));
        }
        $promotional_category->save();
        return redirect()->route('admin.promotional-categories.index')->with('success', "Promotional category created successfully");
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
        $promotional_category = PromotionalCategory::find($id);
        $categories = Category::where('status', 1)->get();
        return view('backend.promotional_category.edit', compact('promotional_category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'category_id' => 'required|integer',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048',
        ]);

        $promotional_category = PromotionalCategory::find($id);
        $promotional_category->title = $request->title;
        $promotional_category->subtitle = $request->subtitle;
        $promotional_category->category_id = $request->category_id;
        if($request->has('image')){
            $promotional_category->image = update_image('promotional_cat/', $promotional_category->image, $request->file('image'));
        }
        $promotional_category->save();
        return redirect()->route('admin.promotional-categories.index')->with('success', "Promotional category update successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotional_category = PromotionalCategory::find($id);
        delete_image($promotional_category->image);
        $promotional_category->delete();
        return redirect()->route('admin.promotional-categories.index')->with('success', "Promotional category deleted successfully");
    }
}
