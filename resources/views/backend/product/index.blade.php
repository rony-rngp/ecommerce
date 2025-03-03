@extends('layouts.backend.app')

@section('title', 'Product List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Product List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary"> Create Product</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($products as $key => $product)
                                <tr>
                                    <td>{{ $products->firstitem()+$key }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="40" src="{{ $product->image != '' && Storage::disk('public')->exists($product->image) ? asset('storage/'.$product->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($product->name, 40) }}</td>
                                    <td>{{ @$product->category->name }} {{ $product->subcategory != null ? ' → '.$product->subcategory->name : '' }}</td>
                                    <td>{{ base_currency().$product->price }}</td>
                                    <td>{{ $product->discount }}%</td>
                                    <td>{{ $product->has_attribute == 1 ? @$product->attributes->sum('stock') : $product->stock }}</td>
                                    <td><span class="badge bg-{{ $product->status == 1 ? 'success' : 'danger' }}">{{ $product->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $product->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                                <!--End Delete Data-->
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.products.gallery', $product->id) }}"><i class="menu-icon tf-icons bx bx-image"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush