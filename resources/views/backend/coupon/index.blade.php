@extends('layouts.backend.app')

@section('title', 'Coupon List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Coupon List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"> Create Coupon</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th>Discount</th>
                                <th>Min Purchase</th>
                                <th>Max Discount Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($coupons as $key => $coupon)
                                <tr>
                                    <td>{{ $coupons->firstitem()+$key }}</td>
                                    <td>{{ $coupon->title }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->start_date }} - {{ $coupon->end_date }}</td>
                                    <td>{{ $coupon->discount }}%</td>
                                    <td>{{ base_currency().$coupon->min_purchase }}</td>
                                    <td>{{ base_currency().$coupon->max_discount }}</td>
                                    <td><span class="badge bg-{{ $coupon->status == 1 ? 'success' : 'danger' }}">{{ $coupon->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.coupons.edit', $coupon->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $coupon->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="post" class="d-none">
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
                            {{ $coupons->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
