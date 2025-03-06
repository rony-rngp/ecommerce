@extends('layouts.backend.app')

@section('title', 'Offline Payment Method List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Offline Payment Method List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.offline-payment-method.create') }}" class="btn btn-primary"> Create Method</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Payment Method Name</th>
                                <th>Payment Info</th>
                                <th>Required Info From Customer</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($offline_payment_methods as $key => $offline_payment_method)
                                <tr>
                                    <td>{{ $offline_payment_methods->firstitem()+$key }}</td>
                                    <td>{{ $offline_payment_method->method_name }}</td>
                                    <td>
                                        @foreach($offline_payment_method->method_fields as $filed)
                                        <span class="d-block">{{ $filed['field_name'] }} : {{ $filed['field_data'] }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($offline_payment_method->method_information as $method_information)
                                        <span class="d-block">{{ $method_information['input_filed_name'] }} : {{ $method_information['input_filed_required'] == 1 ? 'Required' : 'Optional' }}</span>
                                        @endforeach
                                    </td>
                                    <td><span class="badge bg-{{ $offline_payment_method->status == 1 ? 'success' : 'danger' }}">{{ $offline_payment_method->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.offline-payment-method.edit', $offline_payment_method->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $offline_payment_method->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $offline_payment_method->id }}" action="{{ route('admin.offline-payment-method.destroy', $offline_payment_method->id) }}" method="post" class="d-none">
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
                            {{ $offline_payment_methods->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
