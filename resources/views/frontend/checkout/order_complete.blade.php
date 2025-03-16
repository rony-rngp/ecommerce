@extends('layouts.frontend.app')

@section('title', 'Checkout')

@push('css')

@endpush

@section('content')

    <main class="main order">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a href="{{ route('view_cart') }}">Shopping Cart</a></li>
                    <li class="passed"><a href="{{ route('checkout') }}">Checkout</a></li>
                    <li class="active"><a href="javascript:void(0)">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content mb-10 pb-2">
            <div class="container">
                <div class="order-success text-center font-weight-bolder text-dark">
                    <i class="fas fa-check"></i>
                    Thank you. Your order has been received.
                </div>
                <!-- End of Order Success -->

                <ul class="order-view list-style-none">
                    <li>
                        <label>Order number</label>
                        <strong>#{{ $order->id }}</strong>
                    </li>
                    <li>
                        <label>Status</label>
                        <strong>{{ $order->status }}</strong>
                    </li>
                    <li>
                        <label>Date</label>
                        <strong>{{ date('F j, Y', strtotime($order->created_at)) }}</strong>
                    </li>
                    <li>
                        <label>Total</label>
                        <strong>{{ base_currency().$order->grand_total }}</strong>
                    </li>
                    <li>
                        <label>Payment method</label>
                        <strong>{{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif</strong>
                    </li>
                </ul>
                <!-- End of Order View -->

                <div class="order-details-wrapper mb-5">
                    <h4 class="title text-uppercase ls-25 mb-5">Order Details</h4>
                    <table class="order-table">
                        <thead>
                        <tr>
                            <th class="text-dark">Product</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->order_details ?? [] as $order_detail)
                        <tr>
                            <td>
                                <a href="#">{{ Str::limit($order_detail->product_name, 70) }}</a>&nbsp;<strong>x {{ $order_detail->product_qty }}</strong><br>
                            </td>
                            <td>{{ base_currency().($order_detail->product_price*$order_detail->product_qty) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <br>
                        <tr>
                            <th>Subtotal:</th>
                            <td>{{ base_currency().$order->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td> + {{ base_currency().$order->shipping_charge }}</td>
                        </tr>
                        @if($order->coupon_code != '')
                            <tr>
                                <th>Coupon Discount:</th>
                                <td> - {{ base_currency().$order->coupon_discount }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Payment method:</th>
                            <td>{{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif</td>
                        </tr>
                        <tr class="total">
                            <th class="border-no">Total:</th>
                            <td class="border-no">{{ base_currency().$order->grand_total }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- End of Order Details -->



                <a href="{{ route('user.order_list')  }}" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-6"><i class="w-icon-long-arrow-left"></i>Back To List</a>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>

@endsection

@push('js')

@endpush
