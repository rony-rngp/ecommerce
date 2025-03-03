@extends('layouts.backend.app')

@section('title', 'Attribute List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Attribute List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary"> Create Attribute</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($attributes as $key => $attribute)
                                <tr>
                                    <td>{{ $attributes->firstitem()+$key }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.attributes.edit', $attribute->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $attribute->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $attribute->id }}" action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="post" class="d-none">
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
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $attributes->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush