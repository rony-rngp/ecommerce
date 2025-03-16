<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = DynamicPage::paginate(pagination_limit());
        return view('backend.dynamic_page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.dynamic_page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|unique:dynamic_pages,page_name',
            'slug' => 'required|unique:dynamic_pages,slug',
            'content' => 'required',
        ]);

        $dynamic_page = new DynamicPage();
        $dynamic_page->page_name = $request->page_name;
        $dynamic_page->slug = $request->slug;
        $dynamic_page->content = $request['content'];
        $dynamic_page->status = $request->status;
        $dynamic_page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');

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
        $page = DynamicPage::find($id);
        return view('backend.dynamic_page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'page_name' => 'required|unique:dynamic_pages,page_name,'.$id,
            'slug' => 'required|unique:dynamic_pages,slug,'.$id,
            'content' => 'required',
        ]);

        $dynamic_page = DynamicPage::find($id);
        $dynamic_page->page_name = $request->page_name;
        $dynamic_page->slug = $request->slug;
        $dynamic_page->content = $request['content'];
        $dynamic_page->status = $request->status;
        $dynamic_page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dynamic_page = DynamicPage::find($id);
        $dynamic_page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully');
    }
}
