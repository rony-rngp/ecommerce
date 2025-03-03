@extends('layouts.backend.app')

@section('title', 'Sub Category List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Sub Category List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary"> Create Sub Category</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Root Category</th>
                                <th>Name</th>
                                <th>slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($subcategories as $key => $subcategory)
                                <tr>
                                    <td>{{ $subcategories->firstitem()+$key }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="40" src="{{ $subcategory->image != '' && Storage::disk('public')->exists($subcategory->image) ? asset('storage/'.$subcategory->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ @$subcategory->category->name }}</td>
                                    <td>{{ $subcategory->slug }}</td>
                                    <td><span class="badge bg-{{ $subcategory->status == 1 ? 'success' : 'danger' }}">{{ $subcategory->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.subcategories.edit', $subcategory->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $subcategory->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $subcategory->id }}" action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="post" class="d-none">
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
                                    <td colspan="7" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $subcategories->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush