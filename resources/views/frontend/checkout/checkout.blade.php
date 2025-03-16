@extends('layouts.frontend.app')

@section('title', 'Checkout')

@push('css')
<style>
    .is-invalid{border: 1px solid red}
    .v-error{display: block; margin-top: -10px; margin-bottom: 8px}
</style>
@endpush

@section('content')

    <main class="main checkout">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a href="{{ route('view_cart') }}">Shopping Cart</a></li>
                    <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                    <li><a href="javascript:void(0)">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->


        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                <form id="checkoutForm" class="form checkout-form" action="{{ route('checkout_store') }}" method="post">
                    @csrf
                    <div class="row mb-9">

                        <div class="col-lg-7 pr-lg-4 mb-4">

                            @if(\Illuminate\Support\Facades\Auth::check())
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Billing Details
                                </h3>

                                <div class="form-group">
                                    <label for="name">Name <span style="color: red">*</span></label>
                                    <input type="text" class="form-control form-control-md" name="name" required value="{{ Auth::user()->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone <span style="color: red">*</span></label>
                                    <input type="text" class="form-control form-control-md" required value="{{ Auth::user()->phone }}" name="phone">
                                </div>

                                <div class="form-group">
                                    <label>Division</label>
                                    <div class="select-box">
                                        <select name="division" id="division" required class="form-control form-control-md">
                                            <option value="" >Select Your Division</option>
                                            <option value="Barishal">Barishal</option>
                                            <option value="Chattogram">Chattogram</option>
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Khulna">Khulna</option>
                                            <option value="Mymensingh">Mymensingh</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                            <option value="Rangpur">Rangpur</option>
                                            <option value="Sylhet">Sylhet</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Full Address <span style="color: red">*</span></label>
                                    <textarea class="form-control form-control-md" required name="address"></textarea>
                                </div>

                                <div class="text-left" style="list-style-type: none">
                                    <h4 class="title title-simple bb-no mb-1 pb-0 pt-3 mb-3">Shipping Information</h4>
                                    <li class="mb-2">
                                        <div class="custom-radio">
                                            <input type="radio" class="custom-control-input" id="in_dhaka">
                                            <label  class="custom-control-label color-dark">In Dhaka: {{ get_settings('in_dhaka') }} {{ base_currency_name() }}</label>
                                        </div>
                                    </li>
                                    <li class="mb-2">
                                        <div class="custom-radio">
                                            <input type="radio" class="custom-control-input" id="outside_dhaka">
                                            <label  class="custom-control-label color-dark">Outside Dhaka: {{ get_settings('outside_dhaka') }} {{ base_currency_name() }}</label>
                                        </div>
                                    </li>
                                </div>

                            @endif
                        </div>
                        <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                            <div class="order-summary-wrapper sticky-sidebar">
                                <h3 class="title text-uppercase ls-10">Your Order</h3>
                                <div class="order-summary">
                                    <table class="order-table">
                                        <thead>
                                        <tr>
                                            <th colspan="2">
                                                <b>Product</b>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sub_total = 0;
                                        $total_discount = 0;
                                        $grant_total = 0;
                                        $coupon_discount = session()->has('coupon_code') ? session()->get('coupon_discount') : 0;
                                        ?>
                                        @foreach($carts ?? [] as $key => $cart)
                                        <?php
                                        $product = \App\Models\Product::where('status', 1)->where('id', $cart['product_id'])->first();
                                        if($product != null){
                                            $has_attr = false;
                                            $attribute = null;
                                            if($cart['attribute'] != ''){
                                                $has_attr = true;
                                                $attribute = \App\Models\ProductAttribute::where('product_id', $product->id)
                                                    ->where('attribute', $cart['attribute'])->first();
                                            }
                                            $qty = $cart['qty'];
                                            $main_price = 0;
                                            $discount_amount = 0;
                                            $discount_price = 0;
                                            if ($has_attr){
                                                $main_price = @$attribute->price;
                                                if ($product->discount > 0){
                                                    $discount_amount = ($product->discount/100)*@$attribute->price;
                                                    $discount_amount = round($discount_amount);
                                                    $discount_price = round(@$attribute->price-$discount_amount);
                                                }else{
                                                    $discount_amount = 0;
                                                    $discount_price = @$attribute->price;
                                                }
                                            }else{
                                                $main_price = $product->price;
                                                if ($product->discount > 0){
                                                    $discount_amount = ($product->discount/100)*$product->price;
                                                    $discount_amount = round($discount_amount);
                                                    $discount_price = round($product->price-$discount_amount);
                                                }else{
                                                    $discount_amount = 0;
                                                    $discount_price = $product->price;
                                                }
                                            }

                                        }
                                        ?>

                                        <tr class="bb-no">
                                            <td class="product-name">{{ Str::limit($product->name, 35) }} <i
                                                    class="fas fa-times"></i> <span
                                                    class="product-quantity">{{ $qty }}</span></td>
                                            <td class="product-total">{{ base_currency().($discount_price*$qty) }}</td>
                                        </tr>

                                        <?php
                                        $sub_total += ($main_price * $qty) ;
                                        $total_discount += ($discount_amount*$qty);
                                        $grant_total += ($discount_price*$qty);
                                        ?>
                                        @endforeach

                                        <tr class="cart-subtotal bb-no">
                                            <td>
                                                <b>Subtotal</b>
                                            </td>
                                            <td>
                                                <b>{{ base_currency().$grant_total }}</b>
                                            </td>
                                        </tr>
                                        <tr class="cart-subtotal bb-no">
                                            <td>
                                                <b>Coupon Discount</b>
                                            </td>
                                            <td>
                                                <b>- {{ base_currency().$coupon_discount }}</b>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="order-total">
                                            <th>
                                                <b>Shipping</b>
                                            </th>
                                            <td>
                                                <b>+ {{ base_currency() }}<span id="shippingCharge">0</span></b>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>
                                                <b>Total</b>
                                            </th>
                                            <td>
                                                <b id="total_am">{{ base_currency().($grant_total-$coupon_discount) }}</b>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <div class="payment-methods" >
                                        <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                        <div class="accordion payment-accordion">
                                            @if(get_settings('allow_cod') == 1)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#delivery" onclick="setPayment('cod')" class="expand">Cash on delivery</a>
                                                    </div>
                                                    <div id="delivery" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Pay with cash upon delivery.
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(auth()->user()->balance >= ($grant_total-$coupon_discount))
                                                    <div class="card" id="useBalanceDiv">
                                                        <div class="card-header">
                                                            <a href="#account_balance" onclick="setPayment('account_balance')" class="expand">Use Account Balance - <span id="useBalance">{{ base_currency().auth()->user()->balance }}</span></a>
                                                        </div>
                                                        <div id="account_balance" class="card-body collapsed">
                                                            <p class="mb-0">
                                                                Use Account Balance
                                                            </p>
                                                        </div>
                                                    </div>
                                            @endif

                                            @php($online_payment_status = get_settings('online_payment_status'))
                                            @if($online_payment_status == 1)
                                            <div class="card">
                                                <div class="card-header">
                                                    <a href="#ssl_commerz" onclick="setPayment('ssl_commerz')" class="expand">SSL COMMERZ</a>
                                                </div>
                                                <div id="ssl_commerz" class="card-body collapsed">
                                                    <p class="mb-0">
                                                        Pay with SSL COMMERZ
                                                    </p>
                                                </div>
                                            </div>
                                            @endif

                                            @foreach($offline_payment_methods as $offline_payment_method)

                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#{{ $offline_payment_method->method_name }}" onclick="setPayment('{{ $offline_payment_method['id'] }}')" class="expand">{{ $offline_payment_method->method_name }}</a>
                                                    </div>
                                                    <div id="{{ $offline_payment_method->method_name }}" class="card-body collapsed">
                                                        <p class="mb-0">

                                                        <p class="mb-2 text-dark fw-bold" style="font-size: 1.5rem">Required Information for <span class="get_name">{{ $offline_payment_method->method_name }}</span></p>

                                                        <div class="method_filed">
                                                            @foreach($offline_payment_method->method_fields ?? [] as $method_field)
                                                            <p class="mb-1">{{ $method_field['field_name'] }}: {{ $method_field['field_data'] }}</p>
                                                            @endforeach
                                                        </div>

                                                       {{-- <div style="padding-left: 2.7rem">
                                                           " {!! nl2br($offline_payment_method->payment_note) !!} "
                                                        </div>--}}
                                                        @foreach($offline_payment_method['method_information'] as $method_information)
                                                        <?php
                                                            $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                                                            $name = str_replace(' ', '_', $name_data);
                                                            $name = strtolower($name);
                                                        ?>

                                                        <div style="padding-left: 2.7rem">
                                                            <div class="form-group">
                                                                <label for="name">{{ $method_information['input_filed_name'] }} <span style="color: red">*</span></label>
                                                                <input type="text" name="{{ strtolower($offline_payment_method['method_name']).'_'.$name }}" class="form-control form-control-md" {{--{{ $method_information['input_filed_required'] == 1 ? 'required' : '' }}--}} >
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @endforeach

                                            <input type="hidden" name="payment_method" id="payment_method">

                                        </div>
                                    </div>

                                    <div class="form-group place-order pt-6">
                                        <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            let main_total = "{{ $grant_total-$coupon_discount }}";
            main_total = parseFloat(main_total);

            let balance = "{{ auth()->user()->balance }}";
            balance = parseFloat(balance);

            showUseBalanceDiv(balance, main_total);

            let in_dhaka = "{{ get_settings('in_dhaka') }}";
            in_dhaka = parseFloat(in_dhaka);

            let outside_dhaka = "{{ get_settings('outside_dhaka') }}";
            outside_dhaka = parseFloat(outside_dhaka);

            let base_currency = "{{ base_currency() }}";
            $("#division").on('change', function () {
                let division = $("#division").val();
                if (division == 'Dhaka'){
                    document.getElementById("outside_dhaka").checked = false;
                    document.getElementById("in_dhaka").checked = true;
                    $("#total_am").text(base_currency+(main_total+in_dhaka));
                    $("#shippingCharge").text(in_dhaka);
                    showUseBalanceDiv(balance, (main_total+in_dhaka));
                }else{
                    document.getElementById("in_dhaka").checked = false;
                    document.getElementById("outside_dhaka").checked = true;
                    $("#total_am").text(base_currency+(main_total+outside_dhaka));
                    $("#shippingCharge").text(outside_dhaka);
                    showUseBalanceDiv(balance, (main_total+outside_dhaka));
                }
            });


            $(document).on("submit","#checkoutForm",function(){
                var elem = $(this);
                $(elem).find("button[type=submit]").prop("disabled",true);
                var link = $(this).attr("action");
                var formData = new FormData(this);
                $.ajax({
                    method: "POST",
                    url: link,
                    data:  formData,
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        button_val = $(elem).find("button[type=submit]").text();
                        $(elem).find("button[type=submit]").html('Please Wait...');

                    },success: function(res){
                        var json = JSON.parse(res);
                        if(json['result'] == "success"){

                            let payment_method = json.payment_method;
                            let order_id = json.order_id;
                            let encrypt_data = json.encrypt;
                            let query = "b3JkZXJfZGF0YQ";

                            if (payment_method == 'SSLCOMMERZ'){
                                console.log('SSLCOMMERZ');
                                location.href = '{{ route('payment.sslcommerz.pay') }}?'+query+'='+encrypt_data;
                            }else{
                                location.href = '{{ route('order_complete') }}?query='+btoa(order_id);
                            }

                            window.setTimeout(function(){
                                $(elem).find("button[type=submit]").html(button_val);
                                $(elem).find("button[type=submit]").attr("disabled",false);
                            }, 1000);

                        }else{
                            iziToast.error({
                                title: 'Error',
                                message: 'Validation failed. please fill all inputs.',
                            });
                        }
                    },
                    error: function (xhr) {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $(".v-error").addClass('d-none');

                        var data = xhr.responseText;
                        var jsonData = JSON.parse(data);
                        if(jsonData.errors){
                            $.each(jsonData.errors, function (key, value) {
                                var name = key;
                                $("input[name='" + name + "']").addClass('is-invalid');
                                $("select[name='" + name + "'] + span").addClass('is-invalid');
                                $("textarea[name='" + name + "']").addClass('is-invalid');
                                $("input[name='" + name + "'], select[name='" + name + "'], textarea[name='" + name + "']").parent().append("<span class='v-error' style='color: red'>" + value + "</span>");
                                iziToast.error({
                                    title: 'Error',
                                    message: value,
                                    position: 'topRight',
                                });
                            });
                        }else{
                            iziToast.error({
                                title: 'Error',
                                message: jsonData.message,
                                position: 'topRight',
                            });
                        }

                        window.setTimeout(function(){
                            $(elem).find("button[type=submit]").html(button_val);
                            $(elem).find("button[type=submit]").attr("disabled",false);
                        }, 300);
                    }
                });

                return false;
            });

        });
        function setPayment(method){
            var selected = $("#payment_method").val();
            if(selected != method){
                $("#payment_method").val(method);
            }else{
                $("#payment_method").val('');
            }
        }

        function showUseBalanceDiv(balance, grand_total) {
            if(balance >= grand_total){
                $("#useBalanceDiv").removeClass('d-none');
            }else{
                $("#useBalanceDiv").addClass('d-none');
            }
        }
    </script>
@endpush
