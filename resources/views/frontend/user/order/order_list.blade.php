@extends('layouts.frontend.app')

@section('title', 'Order List')

@push('css')
<style>
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive > .table {
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')

    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">My Account</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Orders</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content pt-2">
            <div class="container">
                <div class=" tab-vertical row gutter-lg">

                    @include('frontend.user.user_sidebar')

                    <div class="tab-content mb-6">
                        <div>
                            <div class="icon-box icon-box-side icon-box-light" style="margin-bottom: 10px">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">Orders ({{ $orders->total() }})</h4>
                                </div>

                            </div>


                            <div class="table-responsive" style="white-space: nowrap !important">
                                <table class="shop-table account-orders-table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Order Date</th>
                                        <th>Payment Method</th>
                                        {{--<th>Payment Status</th>--}}
                                        <th>Total Amount</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="text-center">#{{ $order->id }}</td>
                                            <td class="text-center">{{ date('F j, Y', strtotime($order->created_at)) }}</td>
                                            <td class="text-center">
                                                {{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif
                                            </td>
                                            {{--<td class="text-center">
                                                @if($order->payment_status == 1)
                                                    <span style="color: green">Paid</span>
                                                @else
                                                    <span style="color: red">Unpaid</span>
                                                @endif
                                            </td>--}}
                                            <td class="text-center">{{ base_currency().$order->grand_total }}</td>
                                            <td class="text-center">{{ $order->status }}</td>
                                            <td class="order-action">
                                                <a href="{{ route('user.order_details', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Deposit Not Found. Please deposit first</td>
                                        </tr>
                                    @endforelse
                                </table>
                                <div>
                                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        <!-- End of PageContent -->
        <main>

@endsection

@push('js')

@endpush
