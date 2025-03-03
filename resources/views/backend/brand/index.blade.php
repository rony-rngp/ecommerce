@extends('layouts.backend.app')

@section('title', 'Brand List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Brand List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"> Create Brand</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($brands as $key => $brand)
                                <tr>
                                    <td>{{ $brands->firstitem()+$key }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="40" src="{{ $brand->image != '' && Storage::disk('public')->exists($brand->image) ? asset('storage/'.$brand->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td><span class="badge bg-{{ $brand->status == 1 ? 'success' : 'danger' }}">{{ $brand->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.brands.edit', $brand->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $brand->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $brand->id }}" action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                                <!--End Delete Data-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $brands->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush