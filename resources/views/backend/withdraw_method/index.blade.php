@extends('layouts.backend.app')

@section('title', 'Withdraw Method List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Withdraw Method List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.withdraw-methods.create') }}" class="btn btn-primary"> Create Method</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Method Name</th>
                                <th>Required Info From Customer</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($withdraw_methods as $key => $withdraw_method)
                                <tr>
                                    <td>{{ $withdraw_methods->firstitem()+$key }}</td>
                                    <td>{{ $withdraw_method->method_name }}</td>
                                    <td>
                                        @foreach($withdraw_method->method_information as $method_information)
                                            <span class="d-block">{{ $method_information['input_filed_name'] }} : {{ $method_information['input_filed_required'] == 1 ? 'Required' : 'Optional' }}</span>
                                        @endforeach
                                    </td>
                                    <td><span class="badge bg-{{ $withdraw_method->status == 1 ? 'success' : 'danger' }}">{{ $withdraw_method->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.withdraw-methods.edit', $withdraw_method->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $withdraw_method->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $withdraw_method->id }}" action="{{ route('admin.withdraw-methods.destroy', $withdraw_method->id) }}" method="post" class="d-none">
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
                                    <td colspan="5" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $withdraw_methods->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
