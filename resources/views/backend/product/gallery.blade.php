@extends('layouts.backend.app')

@section('title', 'Product Gallery')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Product Gallery</h5>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <li class="mb-2">Product Name : {{ $product->name }}</li>
                                <li class="mb-2">SKU : {{ $product->sku }}</li>
                                <li class="mb-2">Category : {{ @$product->category->name }} {{ $product->subcategory != null ? ' → '.$product->subcategory->name : '' }}</li>
                                <li class="mb-2">Price : {{ base_currency().$product->price }}</li>

                            </div>
                            <div class="col-md-4">
                                <img style="height: 100px; width: 100px" src="{{ asset('storage/'.$product->image) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Add Image</h5>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.gallery', $product->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label  class="form-label" id="image">Choose Image (width:800px height: 990px)</label>
                                    <input type="file" name="image" id="image" accept="image/*" required class="form-control">
                                    <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <button type="submit" class="btn btn-success mt-6">Upload</button>
                                </div>
                            </div>
                        </form>


                        <table class="table table-bordered mt-4">
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>

                            @foreach($product->product_galleries as $key => $gallery)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <img class="object-fit-cover" height="60" width="60" src="{{ $gallery->image != '' && Storage::disk('public')->exists($gallery->image) ? asset('storage/'.$gallery->image) : asset('backend/no_image.png') }}" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.gallery.destroy', $gallery->id) }}" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
