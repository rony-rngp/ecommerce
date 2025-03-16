@extends('layouts.backend.app')

@section('title', 'Order List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Order List ({{ $orders->count() }})</h5>
                    </div>

                    <form action="{{ url()->current() }}" method="get">
                        <div class="row p-5">
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Email <i class="text-danger">*</i></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>

                            <div class="mb-4 col-md-4">
                                <label class="form-label" for="status">Order Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Select One</option>
                                    <option {{ old('status') == 'Pending' ? 'selected' : '' }} value="Pending">Pending</option>
                                    <option {{ old('status') == 'Confirmed' ? 'selected' : '' }} value="Confirmed">Confirmed</option>
                                    <option {{ old('status') == 'Processing' ? 'selected' : '' }} value="Processing">Processing</option>
                                    <option {{ old('status') == 'Out for delivery' ? 'selected' : '' }} value="Out for delivery">Out for delivery</option>
                                    <option {{ old('status') == 'Delivered' ? 'selected' : '' }} value="Delivered">Delivered</option>
                                    <option {{ old('status') == 'Returned' ? 'selected' : '' }} value="Returned">Returned</option>
                                    <option {{ old('status') == 'Failed' ? 'selected' : '' }} value="Failed">Failed</option>
                                    <option {{ old('status') == 'Cancelled' ? 'selected' : '' }} value="Cancelled">Cancelled</option>
                                </select>
                                <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                            </div>

                            <div class="mb-4 col-md-4">
                                <div class="mt-6">
                                    <button type="submit" class="btn btn-primary ">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Order Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Is Seen</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <span class="d-block">{{ @$order->user->name }}</span>
                                        <span class="d-block">{{ @$order->user->email }}</span>
                                    </td>
                                    <td>{{ date('F j, Y', strtotime($order->created_at)) }}</td>
                                    <td>
                                        {{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status == 1)
                                            <span class="text-primary">Paid</span>
                                        @else
                                            <span class="text-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>{{ base_currency().$order->grand_total }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        @if($order->is_seen == 1)
                                            <span class="badge bg-success">Seen</span>
                                        @else
                                            <span class="badge bg-danger">Unseen</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.orders.details', $order->id) }}">Details</a>
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
                            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
