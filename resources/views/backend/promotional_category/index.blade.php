@extends('layouts.backend.app')

@section('title', 'Promotional Category List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Promotional Category List</h5>
                        <div class="me-5">
                            @if (\App\Models\PromotionalCategory::count() < 2)
                                <a href="{{ route('admin.promotional-categories.create') }}" class="btn btn-primary"> Create Promotion</a>
                            @endif

                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($promotional_categories as $key => $promotional_category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ @$promotional_category->category->name }}</td>
                                    <td>{{ $promotional_category->title }}</td>
                                    <td>{{ $promotional_category->subtitle }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="80" src="{{ $promotional_category->image != '' && Storage::disk('public')->exists($promotional_category->image) ? asset('storage/'.$promotional_category->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.promotional-categories.edit', $promotional_category->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $promotional_category->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $promotional_category->id }}" action="{{ route('admin.promotional-categories.destroy', $promotional_category->id) }}" method="post" class="d-none">
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
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
