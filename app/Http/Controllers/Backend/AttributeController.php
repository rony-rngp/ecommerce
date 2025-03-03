<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::paginate(pagination_limit());
        return view('backend.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:attributes,name'
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully!');
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
        $attribute = Attribute::find($id);
        return view('backend.attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:attributes,name,'.$id
        ]);

        $attribute = Attribute::find($id);
        $attribute->name = $request->name;
        $attribute->save();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = Attribute::find($id);
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully!');
    }

    public function assign_attribute()
    {

    }

}
