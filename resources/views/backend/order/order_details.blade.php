@extends('layouts.backend.app')

@section('title', 'Order Details')

@push('css')
<style>
    .card-header{
        padding: 14px 20px;
    }
    @media (max-width: 576px) {
        .tbl_res{
            white-space: nowrap !important
        }
    }
</style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">Order Details &nbsp; - &nbsp; ( ID: {{ $order->id }} )</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ date('F j, Y', strtotime($order->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>
                                    {{ $order->payment_method == 'account_balance' ? ucfirst(str_replace('_', ' ', $order->payment_method)) : ucfirst($order->payment_method) }} @if($order->payment_type != null) ({{ ucfirst($order->payment_type) }}) @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Shipping</th>
                                <td>
                                    {{ $order->shipping_type }}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>{{ $order->grand_total }} {{ base_currency_name() }}</td>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td>{{ $order->status }}</td>
                            </tr>
                            @if($order->payment_type == 'offline')
                                <tr>
                                    <th colspan="2" class="text-center">
                                        Offline Payment Info :

                                        <div class="d-flex mt-3" style="gap: 20px; justify-content: center">
                                            <span class="d-block">Payment Status : </span>
                                            <div class="form-check form-switch" style="margin-bottom: 0;">
                                                <input class="form-check-input payment_status" type="checkbox" {{ $order->payment_status == 1 ? 'checked' : '' }} role="switch" id="payment_status">
                                                <label class="form-check-label" for="payment_status">{{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}</label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                @foreach($order->offline_payment_info ?? [] as $offline_payment_info)
                                    <tr>
                                        <th>{{ $offline_payment_info['key'] }}</th>
                                        <td>{{ $offline_payment_info['value'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        @if($order->payment_status == 1)
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($order->payment_method != 'account_balance')
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $order->transaction_id ?? '-' }}</td>
                                </tr>
                                @endif
                            @endif

                        </table>
                    </div>

                </div>

                <div class="card mb-6">
                    <div class="table-responsive tbl_res">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
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

            <div class="col-md-4">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Update Order Status</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('admin.orders.update_status', $order->id) }}" onsubmit="return confirm('Are you sure?')" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select" required>
                                    <option {{ $order->status == 'Pending' ? 'selected' : '' }} value="Pending">Pending</option>
                                    <option {{ $order->status == 'Confirmed' ? 'selected' : '' }} value="Confirmed">Confirmed</option>
                                    <option {{ $order->status == 'Processing' ? 'selected' : '' }} value="Processing">Processing</option>
                                    <option {{ $order->status == 'Out for delivery' ? 'selected' : '' }} value="Out for delivery">Out for delivery</option>
                                    <option {{ $order->status == 'Delivered' ? 'selected' : '' }} value="Delivered">Delivered</option>
                                    <option {{ $order->status == 'Returned' ? 'selected' : '' }} value="Returned">Returned</option>
                                    <option {{ $order->status == 'Failed' ? 'selected' : '' }} value="Failed">Failed</option>
                                    <option {{ $order->status == 'Cancelled' ? 'selected' : '' }} value="Cancelled">Cancelled</option>
                                </select>
                                <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary validate">Update</button>
                        </form>
                    </div>
                </div>

                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Shipping Information</h5>
                    </div>
                    <table class="table table-bordered">

                        <tr>
                            <th>Name</th>
                            <td>{{ @$order['shipping_info']['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ @$order['shipping_info']['phone'] }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Type</th>
                            <td>{{ @$order->shipping_type }}</td>
                        </tr>
                        <tr>
                            <th>Division</th>
                            <td>{{ @$order['shipping_info']['division'] }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Delivery Address</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">{{ @$order['shipping_info']['address'] }}</th>
                        </tr>
                    </table>
                </div>


                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Customer Information</h5>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{ @$order->user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ @$order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ @$order->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ @$order->user->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
<script>
    $(".payment_status").on('change', function () {
        let payment_status = $(this).prop('checked');
        if (payment_status) {
            payment_status = 1;
        } else {
            payment_status = 0;
        }

        $.ajax({
            url : "{{ route('admin.orders.update_payment_status') }}",
            type : 'get',
            data : {payment_status:payment_status, order_id: '{{ $order->id }}'},
            success:function (res) {
                location.reload();
            }
        });

    });

</script>
@endpush
