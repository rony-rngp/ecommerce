@extends('layouts.frontend.app')

@section('title', 'Shopping Cart')

@push('css')

    <style>
        .empty-cart {
            text-align: center;
            padding: 50px;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
            margin-top: 0;
            margin-bottom: 0;
        }

        .empty-cart-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .empty-cart h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }


    </style>
@endpush

@section('content')

    <main class="main cart">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="active"><a href="{{ route('view_cart') }}">Shopping Cart</a></li>
                    <li><a href="javascript:void(0)">Checkout</a></li>
                    <li><a href="javascript:void(0)">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                @if(count($carts) > 0)
                <div class="row gutter-lg mb-10">
                    <div class="col-lg-8 pr-lg-4 mb-6">
                        <table class="shop-table cart-table">
                            <thead>
                            <tr>
                                <th class="product-name"><span>Product</span></th>
                                <th></th>
                                <th class="product-price"><span>Price</span></th>
                                <th class="product-quantity"><span>Quantity</span></th>
                                <th class="product-subtotal"><span>Subtotal</span></th>
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
                                    //$product = \App\Models\Product::where('status', 1)->where('id', 100)->first();
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
                                @if($product != null)
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="{{ route('product_details', $product->slug) }}">
                                                <figure>
                                                    <img src="{{ asset('storage/'.$product->image) }}" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>

                                            <button onclick="if (confirm('Are you sure?')) { window.location.href = '{{ route('remove_item_cart', $key) }}'; }" type="button" class="btn btn-close"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="{{ route('product_details', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                        @if($cart['color_name'] != '')
                                        <span class="d-block">Color : {{ $cart['color_name'] }}</span>
                                        @endif
                                        @if($has_attr)
                                        <span class="d-block">{{ $product->attribute_title }} : {{ $cart['attribute'] }}</span>
                                        @endif
                                    </td>

                                    <td class="product-price text-center"><span class="amount">{{ base_currency().$discount_price }}</span></td>

                                    @if($product == null)
                                        <td style="color: red">Product not available</td>
                                    @elseif($has_attr && $attribute == null )
                                        <td style="color: red">Attribute not available</td>
                                    @elseif($has_attr && $attribute->stock == 0 )
                                        <td style="color: red">This {{ $product->attribute_title }} is out of stock</td>
                                    @elseif($has_attr && $attribute->stock < $qty )
                                        <td style="color: red"> Quantity is not available </td>
                                    @elseif(!$has_attr && $product->stock == 0)
                                        <td style="color: red">This product is out of stock</td>
                                    @elseif(!$has_attr && $product->stock < $qty)
                                        <td style="color: red"> Quantity is not available</td>
                                    @else
                                    <td class="product-quantity text-center">
                                        <div class="input-group">
                                            <input class="quantity_val{{$key}} form-control" value="{{ $qty }}" type="number" min="1" max="5">
                                            <button onclick="updateQty('add', '{{ $key }}')" class="quantity-plus w-icon-plus"></button>
                                            <button onclick="updateQty('remove', '{{ $key }}')" class="quantity-minus w-icon-minus"></button>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="product-subtotal text-center">
                                        <span class="amount">{{ base_currency().($discount_price*$qty) }}</span>
                                    </td>
                                </tr>
                                @else
                                    <tr>
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="javascript:void(0)">
                                                    <figure>
                                                        <img src="{{ asset('frontend/assets/images/cart/product-1.jpg') }}" alt="product"
                                                             width="300" height="338">
                                                    </figure>
                                                </a>

                                                <button onclick="if (confirm('Are you sure?')) { window.location.href = '{{ route('remove_item_cart', $key) }}'; }" type="button" class="btn btn-close"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </td>
                                        <td colspan="4" style="text-align: center; color: red">
                                            Sorry, Product not available. Please remove it from cart
                                        </td>
                                    </tr>
                                @endif

                                <?php
                                 $sub_total += ($main_price * $qty) ;
                                 $total_discount += ($discount_amount*$qty);
                                 $grant_total += ($discount_price*$qty);
                                ?>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="cart-action mb-6">
                            <a href="{{ url('/') }}" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                            <a onclick="return confirm('Are you sure?')" href="{{ route('clear_cart') }}" class="btn btn-rounded btn-default btn-clear" >Clear Cart</a>
                        </div>
                        <style>
                            input[readonly], textarea[readonly] {
                                background-color: #f0f0f0;  /* Light grey background */
                                color: #888;  /* Grey text */
                            }
                        </style>
                        <form class="coupon" id="couponForm">
                            <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount  @if(session()->has('coupon_code')) (<i class="w-icon-check"></i> Coupon Applied) @endif</h5>
                            <input type="text" class="form-control mb-4 text-dark"  {{ session()->has('coupon_code') ? 'readonly' : '' }} value="{{ session()->has('coupon_code') ? session()->get('coupon_code') : '' }}" id="coupon_filed" placeholder="Enter coupon code here..." required />
                            <button type="button" onclick="applyCoupon()" class="btn mb-3 btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            &nbsp;
                            @if(session()->has('coupon_code'))
                            <a href="{{ route('remove_coupon') }}"  onclick="return confirm('Are you sure?')" class="btn btn-warning btn-outline btn-rounded">Remove Coupon</a>
                            @endif
                        </form>
                    </div>
                    <div class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar">
                            <div class="cart-summary mb-4">
                                <h3 class="cart-title text-uppercase">Cart Totals</h3>

                                <hr class="divider mb-6">
                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label>Subtotal</label>
                                    <span class="ls-50">{{ base_currency().$sub_total }}</span>
                                </div>
                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label>Discount Amount</label>
                                    <span class="ls-50">- {{ base_currency().$total_discount }}</span>
                                </div>

                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label>Coupon Discount</label>
                                    <span class="ls-50"> - {{ base_currency().$coupon_discount }}</span>
                                </div>
                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label>Total</label>
                                    <span class="ls-50"> {{ base_currency().($grant_total-$coupon_discount) }}</span>
                                </div>
                                <a href="{{ route('checkout') }}"
                                   class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                    Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @else

                    <div class="row gutter-lg mb-10">
                        <div class="col-md-12">
                            <div class="empty-cart">
                                <img src="{{ asset('frontend/assets/images/empty_cart.png') }}" alt="Empty Cart" class="empty-cart-icon">

                                <h2>Your Cart is Empty</h2>
                                <p>It seems you haven't added anything to your cart yet.</p>
                                <a href="{{ url('/') }}" class="btn btn-warning">Start Shopping</a>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- End of PageContent -->
    </main>

@endsection

@push('js')
<script>
    function updateQty(type, key) {

        var qty  = $(".quantity_val"+key).val();
        qty = parseInt(qty);
        if(type == 'add'){
            qty = qty+1;
        }else{
            if(qty > 1){
                qty = qty-1;
            }else{
                return false;
            }
        }

        if(qty >= 1){
            $.ajax({
                url : "{{ route('update_qty') }}",
                type : "get",
                data : {type:type, key:key},
                success:function (res) {
                    if(res.status == true){
                        $(".quantity_val"+key).val(qty);
                        location.reload();
                    }else{
                        iziToast.error({
                            title: 'Error',
                            message: res.message,
                            position: "topRight",
                        });
                    }
                }
            });
        }

    }

    function applyCoupon() {
        let coupon = $("#coupon_filed").val();
        if(coupon == ''){
            iziToast.error({
                title: 'Error',
                message: 'Please enter a valid coupon',
                position: "topRight",
            });
            return false;
        }

        $.ajax({
            url : "{{ route('apply_coupon') }}",
            type : "get",
            data : {coupon:coupon},
            success:function (res) {
                if(res.status == true){
                    iziToast.success({
                        title: 'Success',
                        message: res.message,
                        position: "topRight",
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 500);

                }else{
                    iziToast.error({
                        title: 'Error',
                        message: res.message,
                        position: "topRight",
                    });
                }
            }
        });

    }


</script>
@endpush
