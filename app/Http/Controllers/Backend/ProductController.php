<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'subcategory', 'attributes')->latest()->paginate(pagination_limit());
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::get();
        $data['brands'] = Brand::get();
        $data['colors'] = Color::get();
        return view('backend.product.create', $data);
    }


    public function get_subcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'slug' => 'required|unique:products,name',
            'category_id' => 'required|integer',
            'subcategory_id' => 'nullable|integer',
            'brand_id' => 'required|integer',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric',
            'discount' => 'required|integer',
            'short_description' => 'required',
            'description' => 'required',
            'stock' => $request->has_attribute == null ? 'required|numeric' : 'nullable',
            'attribute_title' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'attribute.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'att_price.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'att_stock.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        try {

            DB::transaction(function () use ($request){

                $product = new Product();
                $product->category_id = $request->category_id;
                $product->subcategory_id = $request->subcategory_id;
                $product->brand_id = $request->brand_id;
                $product->sku = $request->sku;
                $product->name = $request->name;
                $product->slug = $request->slug;
                $product->price = $request->price;
                $product->discount = $request->discount;
                $product->short_description = $request->short_description;
                $product->description = $request->description;
                if ($request->has_attribute == 1){
                    $product->has_attribute = 1;
                    $product->attribute_title = $request->attribute_title;
                }else{
                    $product->has_attribute = 0;
                    $product->stock = $request->stock;
                }
                $product->status = $request->status;
                if($request->has('image')){
                    $product->image = upload_image('product/', $request->file('image'));
                }
                $product->save();

                if ($product->has_attribute == 1){
                    foreach ($request->attribute ?? [] as $key => $attribute){
                        $attribute_count = ProductAttribute::where('product_id', $product->id)->where('attribute', $attribute)->count();
                        if ($attribute_count == 0){
                            $product_attribute = new ProductAttribute();
                            $product_attribute->product_id = $product->id;
                            $product_attribute->attribute = $attribute;
                            $product_attribute->price = $request->att_price[$key];
                            $product_attribute->stock = $request->att_stock[$key];
                            $product_attribute->save();
                        }
                    }
                }

                if ($request->color_id != null){
                    foreach ($request->color_id ?? [] as $color_id){
                        $color = Color::find($color_id);
                        if ($color){
                            $product_color = new ProductColor();
                            $product_color->product_id = $product->id;
                            $product_color->color_name = $color->color_name;
                            $product_color->color_code = $color->color_code;
                            $product_color->save();
                        }
                    }
                }
            });

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');

        }catch (\Exception $exception){
            $request->flash();
            return redirect()->back()->with('error', $exception->getMessage());
        }



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
        $data['categories'] = Category::get();
        $data['brands'] = Brand::get();
        $data['colors'] = Color::get();
        $data['product'] = Product::with('product_colors', 'attributes')->find($id);
        $data['subcategories'] = Subcategory::where('category_id', $data['product']['category_id'])->get();
        return view('backend.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,'.$id,
            'slug' => 'required|unique:products,name,'.$id,
            'category_id' => 'required|integer',
            'subcategory_id' => 'nullable|integer',
            'brand_id' => 'required|integer',
            'sku' => 'required|unique:products,sku,'.$id,
            'price' => 'required|numeric',
            'discount' => 'required|integer',
            'short_description' => 'required',
            'description' => 'required',
            'stock' => $request->has_attribute == null ? 'required|numeric' : 'nullable',
            'attribute_title' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'attribute.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'att_price.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'att_stock.*' =>  $request->has_attribute == 1 ? 'required' : 'nullable',
            'status' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        try {

            DB::transaction(function () use ($request, $id){

                $product = Product::find($id);
                $product->category_id = $request->category_id;
                $product->subcategory_id = $request->subcategory_id;
                $product->brand_id = $request->brand_id;
                $product->sku = $request->sku;
                $product->name = $request->name;
                $product->slug = $request->slug;
                $product->price = $request->price;
                $product->discount = $request->discount;
                $product->short_description = $request->short_description;
                $product->description = $request->description;
                if ($request->has_attribute == 1){
                    $product->has_attribute = 1;
                    $product->attribute_title = $request->attribute_title;
                    $product->stock = 0;
                }else{
                    $product->has_attribute = 0;
                    $product->stock = $request->stock;

                    $product->attribute_title = '';
                    ProductAttribute::where('product_id', $product->id)->delete();
                }
                $product->status = $request->status;
                if($request->has('image')){
                    $product->image = update_image('product/', $product->image, $request->file('image'));
                }
                $product->save();

                if ($product->has_attribute == 1){
                    $data = [];
                    $product = Product::find($id);
                    foreach ($request->attribute ?? [] as $key => $attribute) {
                        $data[] = $product->attributes()->updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'attribute' => $attribute
                            ],
                            [
                                'price' => $request->att_price[$key],
                                'stock' => $request->att_stock[$key]
                            ]
                        );
                    }
                    $product->attributes()->whereNotIn('id', collect($data)->pluck('id'))->delete();
                }

                if ($request->color_id != null){
                    ProductColor::where('product_id', $product->id)->delete();
                    foreach ($request->color_id ?? [] as $color_id){
                        $color = Color::find($color_id);
                        if ($color){
                            $product_color = new ProductColor();
                            $product_color->product_id = $product->id;
                            $product_color->color_name = $color->color_name;
                            $product_color->color_code = $color->color_code;
                            $product_color->save();
                        }
                    }
                }
            });

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');

        }catch (\Exception $exception){
            $request->flash();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function product_gallery(Request $request, $id)
    {
         $product = Product::with('product_galleries')->find($id);

        if ($request->isMethod('post')){

            $request->validate([
                'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
            ]);

            $product_gallery = new ProductGallery();
            $product_gallery->product_id = $product->id;
            $product_gallery->image = upload_image('product/gallery/', $request->file('image'));
            $product_gallery->save();

            return redirect()->back()->with('success', 'Image added successfully');

        }
        return view('backend.product.gallery', compact('product'));
    }

    public function product_gallery_destroy($id)
    {
        $product_gallery = ProductGallery::find($id);
        delete_image($product_gallery->image);
        $product_gallery->delete();
        return redirect()->back()->with('success', 'Image deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        delete_image($product->image);
        ProductAttribute::where('product_id', $product->id)->delete();
        ProductColor::where('product_id', $product->id)->delete();
        $product_galleries = ProductGallery::where('product_id', $product->id)->get();
        foreach ($product_galleries as $gallery){
            delete_image($gallery->image);
            $gallery->delete();
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
