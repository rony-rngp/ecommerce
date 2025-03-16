@extends('layouts.frontend.app')

@section('title', 'Dashboard')

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
        @media (max-width: 576px) {
            .tbl_res{
                white-space: nowrap !important
            }
        }


        /* General card styling */
        .custom-card {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card-title{
            padding: 16px 20px;
            margin: 0;
            padding-bottom: 5px;
        }

        /* Hover effect */
        .custom-card:hover {
            /*transform: translateY(-10px);*/
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        /* Card body */
        .custom-card-body {
            padding: 15px;
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
                        <div class="order-details">

                            <div class="mb-6">
                                <div class="custom-card" id="orderInfo">
                                    <h4 class="custom-card-title">Order Information - ({{ $order->status }})</h4>

                                    <div class="custom-card-body">
                                        <div class="table-responsive" style="white-space: nowrap !important">
                                            <table class="shop-table account-orders-table">
                                                <tr>
                                                    <td>ID</td>
                                                    <td>{{ $order->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Date</td>
                                                    <td>{{ date('F j, Y', strtotime($order->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method</td>
                                                    <td>
                                                        {{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping</td>
                                                    <td>
                                                        {{ $order->shipping_type }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td>{{ $order->grand_total }} {{ base_currency_name() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Status</td>
                                                    <td>{{ $order->status }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Status</td>
                                                    <td>
                                                        @if($order->payment_status == 1)
                                                            <span class="badge bg-success">Paid</span>
                                                        @else
                                                            <span class="badge bg-danger">Unpaid</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($order->payment_type == 'offline')
                                                    <tr>
                                                        <td colspan="2" class="text-center">
                                                            Offline Payment Info :
                                                        </td>
                                                    </tr>
                                                    @foreach($order->offline_payment_info ?? [] as $offline_payment_info)
                                                        <tr>
                                                            <td>{{ $offline_payment_info['key'] }}</td>
                                                            <td>{{ $offline_payment_info['value'] ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @if($order->payment_method != 'account_balance')
                                                        <tr>
                                                            <td>Transaction ID</td>
                                                            <td>{{ $order->transaction_id ?? '-' }}</td>
                                                        </tr>
                                                    @endif
                                                @endif

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="custom-card mb-6">
                                <div class="custom-card-body">
                                    <div class="table-responsive tbl_res">
                                        <table class="shop-table account-orders-table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-left">Product</th>
                                                <th class="text-left">Price</th>
                                                <th class="text-left">Qty</th>
                                                <th class="text-left">Total</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($order->order_details ?? [] as $order_details)
                                                <tr>
                                                    <td style="color: #333; width: 50%!important;">
                                                        <span class="d-block">{{ $order_details->product_name }}</span>
                                                        @if($order_details->product_color != '')
                                                            <span class="d-block">Color : {{ $order_details->product_color }}</span>
                                                        @endif
                                                        @if($order_details->has_attribute == 1)
                                                            <span class="d-block">{{ $order_details->attribute_title }} : {{ $order_details->product_attribute }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-dark">{{ base_currency().$order_details->product_price }}</td>
                                                    <td class="text-dark">{{ $order_details->product_qty }}</td>
                                                    <td class="text-dark fw-bold">{{ base_currency().($order_details->product_price*$order_details->product_qty) }}</td>
                                                </tr>
                                            @endforeach

                                            <tr class="cart-subtotal bb-no">
                                                <td></td>
                                                <td colspan="2" class="text-end text-center text-dark">
                                                    <b>Subtotal :</b>
                                                </td>
                                                <td class="text-dark">
                                                    <b>&nbsp;{{ base_currency().$order->subtotal }}</b>
                                                </td>
                                            </tr>

                                            <tr class="cart-subtotal bb-no">
                                                <td></td>
                                                <td colspan="2" class="text-end text-center text-dark">
                                                    <b>Shipping Charge :</b>
                                                </td>
                                                <td class="text-dark">
                                                    <b> + {{ base_currency().$order->shipping_charge }}</b>
                                                </td>
                                            </tr>


                                            <tr class="cart-subtotal bb-no">
                                                <td></td>
                                                <td colspan="2" class="text-end text-center text-dark">
                                                    <b>Coupon Discount @if($order->coupon_code != '')({{ $order->coupon_code }})@endif :</b>
                                                </td>
                                                <td class="text-dark">
                                                    <b> - {{ base_currency().$order->coupon_discount }}</b>
                                                </td>
                                            </tr>

                                            <tr class="cart-subtotal bb-no">
                                                <td></td>
                                                <td colspan="2" class="text-end text-center text-dark">
                                                    <b>Total Amount :</b>
                                                </td>
                                                <td class="text-dark">
                                                    <b>&nbsp;{{ base_currency().$order->grand_total }}</b>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="custom-card">
                                    <h4 class="custom-card-title">Shipping Information</h4>

                                    <div class="custom-card-body">
                                        <div class="table-responsive" style="white-space: nowrap !important">
                                            <table class="shop-table account-orders-table">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{ @$order['shipping_info']['name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>{{ @$order['shipping_info']['phone'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Type</td>
                                                    <td>{{ @$order->shipping_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Division</td>
                                                    <td>{{ @$order['shipping_info']['division'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-center">Delivery Address</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-center">{{ @$order['shipping_info']['address'] }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

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
