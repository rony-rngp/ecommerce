@extends('layouts.frontend.app')

@section('title', 'Home')

@push('css')
    <style>
        @media (min-width: 1200px) {
            .redponsiveImg{
                width: 232px !important; height: 261px !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .redponsiveImg{
                height: 251px !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991.98px) {
            .redponsiveImg{
                height: 188px !important;
            }
        }
        @media (max-width: 767.98px) {
            .redponsiveImg{
                height: 186px !important;
            }
        }
    </style>
    <style>
        .playBtn{ position: absolute; top: 38%; left: 45%; height: 50px; width: 50px; background: #0000007d; border-radius: 50%}
        .playBtn .platIcon{font-size: 20px; top: 15px; right: 15px; position: absolute; color: white}
    </style>
@endpush

@section('content')

    <main class="main">
        <section class="intro-section">
            <div class="swiper-container swiper-theme nav-inner pg-inner swiper-nav-lg animation-slider pg-xxl-hide nav-xxl-show nav-hide"
                 data-swiper-options="{
                        'slidesPerView': 1,
                        'autoplay': {
                            'delay': 8000,
                            'disableOnInteraction': false
                        }
                    }">
                <div class="swiper-wrapper">
                    @foreach($sliders as $key => $slider)
                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide1"
                         style="background-image: url({{ check_image($slider->background_image) ? asset('storage/'.$slider->background_image) : asset('frontend//assets/images/demos/demo1/sliders/slide-1.jpg') }}); background-color: #ebeef2;">
                        <div class="container">
                            <figure class="slide-image skrollable slide-animate">
                                <img src="{{ check_image($slider->image) ? asset('storage/'.$slider->image) : '' }}" alt="Banner"
                                     data-bottom-top="transform: translateY(10vh);"
                                     data-top-bottom="transform: translateY(-10vh);" width="474" height="397">
                            </figure>
                            <div class="banner-content y-50 text-right">
                                <h5 class="banner-subtitle font-weight-normal text-default ls-50 lh-1 mb-2 slide-animate"
                                    data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'duration': '1s',
                                        'delay': '.2s'
                                    }">
                                    {{ $slider->first_title }}
                                </h5>
                                <h3 class="banner-title font-weight-bolder ls-25 lh-1 slide-animate"
                                    data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'duration': '1s',
                                        'delay': '.4s'
                                    }">
                                    {{ $slider->second_title }}
                                </h3>
                                <p class="font-weight-normal text-default slide-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'duration': '1s',
                                        'delay': '.6s'
                                    }">
                                    {{ $slider->third_title }}
                                </p>

                                <a @if($slider->type == 'product')
                                       href="{{ route('product_details', @$slider->product->slug) }}"
                                   @else
                                       href="{{ route('category_product', ['category' => @$slider->category->slug]) }}"
                                   @endif
                                   class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                   data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'duration': '1s',
                                        'delay': '.8s'
                                    }">SHOP NOW<i class="w-icon-long-arrow-right"></i></a>

                            </div>
                            <!-- End of .banner-content -->
                        </div>
                        <!-- End of .container -->
                    </div>
                    @endforeach
                    <!-- End of .intro-slide1 -->
                </div>
                <div class="swiper-pagination"></div>
                <button class="swiper-button-next"></button>
                <button class="swiper-button-prev"></button>
            </div>
            <!-- End of .swiper-container -->
        </section>
        <!-- End of .intro-section -->

        <div class="container">
            <div class="swiper-container appear-animate icon-box-wrapper br-sm {{--mt-6--}} {{--mb-6--}} mb-8 mt-8" data-swiper-options="{
                        'slidesPerView': 1,
                        'loop': false,
                        'breakpoints': {
                            '576': {
                                'slidesPerView': 2
                            },
                            '768': {
                                'slidesPerView': 3
                            },
                            '1200': {
                                'slidesPerView': 3
                            }
                        }
                    }">
                <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                    <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                                <span class="icon-box-icon icon-shipping">
                                    <i class="w-icon-truck"></i>
                                </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1"> Shipping Charge</h4>
                            <p class="text-default"> In Dhaka {{ get_settings('in_dhaka').' '.base_currency_name() }} and outside {{ get_settings('outside_dhaka').' '.base_currency_name() }}</p>
                        </div>
                    </div>
                    <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                                <span class="icon-box-icon icon-payment">
                                    <i class="w-icon-bag"></i>
                                </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Secure Payment</h4>
                            <p class="text-default">We ensure secure payment</p>
                        </div>
                    </div>
                    <div class="swiper-slide icon-box icon-box-side icon-box-primary icon-box-chat">
                                <span class="icon-box-icon icon-chat">
                                    <i class="w-icon-chat"></i>
                                </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Customer Support</h4>
                            <p class="text-default">Call or email us 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Iocn Box Wrapper -->

            {{--<div class="row category-banner-wrapper appear-animate pt-6 pb-8">
                <div class="col-md-6 mb-4">
                    <div class="banner banner-fixed br-xs">
                        <figure>
                            <img src="{{ asset('frontend') }}/assets/images/demos/demo1/categories/1-1.jpg" alt="Category Banner"
                                 width="610" height="160" style="background-color: #ecedec;" />
                        </figure>
                        <div class="banner-content y-50 mt-0">
                            <h5 class="banner-subtitle font-weight-normal text-dark">Get up to <span
                                        class="text-secondary font-weight-bolder text-uppercase ls-25">20% Off</span>
                            </h5>
                            <h3 class="banner-title text-uppercase">Sports Outfits<br><span
                                        class="font-weight-normal                       text-capitalize">Collection</span>
                            </h3>
                            <div class="banner-price-info font-weight-normal">Starting at <span
                                        class="text-secondary                       font-weight-bolder">$170.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="banner banner-fixed br-xs">
                        <figure>
                            <img src="{{ asset('frontend') }}/assets/images/demos/demo1/categories/1-2.jpg" alt="Category Banner"
                                 width="610" height="160" style="background-color: #636363;" />
                        </figure>
                        <div class="banner-content y-50 mt-0">
                            <h5 class="banner-subtitle font-weight-normal text-capitalize">New Arrivals</h5>
                            <h3 class="banner-title text-white text-uppercase">Accessories<br><span
                                        class="font-weight-normal text-capitalize">Collection</span></h3>
                            <div class="banner-price-info text-white font-weight-normal text-capitalize">Only From
                                <span class="text-secondary font-weight-bolder">$90.00</span></div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <!-- End of Category Banner Wrapper -->

            @if(count($hot_deals) > 0)
            <div id="hotDeals">
                @include('frontend.hot_deals')
            </div>
            @endif

            <!-- End of Deals Wrapper -->
        </div>

        <section class="category-section top-category bg-grey pt-10 pb-10 appear-animate">
            <div class="container pb-2">
                <h2 class="title justify-content-center pt-1 ls-normal mb-5">Top Categories Of The Month</h2>
                <div class="swiper">
                    <div class="swiper-container swiper-theme pg-show" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '576': {
                                        'slidesPerView': 3
                                    },
                                    '768': {
                                        'slidesPerView': 5
                                    },
                                    '992': {
                                        'slidesPerView': 6
                                    }
                                }
                            }">
                        <div class="swiper-wrapper row cols-lg-6 cols-md-5 cols-sm-3 cols-2">
                            @foreach($app_categories as $category)
                            <div
                                    class="swiper-slide category category-classic category-absolute overlay-zoom br-xs">
                                <a href="{{ route('category_product', ['category' => $category->slug]) }}" class="category-media">
                                    <img  src="{{ check_image($category->image) ? asset('storage/'.$category->image) :  asset('frontend/assets/images/demos/demo1/categories/2-1.jpg') }}" alt="Category"
                                         width="130" style="height: 184px">
                                </a>
                                <div class="category-content">
                                    <h4 class="category-name">{{ $category->name }}</h4>
                                    <a href="{{ route('category_product', ['category' => $category->slug]) }}" class="btn btn-primary btn-link btn-underline">Shop Now</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of .category-section top-category -->

        <div class="container">
        <h2 class="title justify-content-center ls-normal mb-4 mt-10 pt-1 appear-animate">Popular Departments
        </h2>
        <div class="tab tab-nav-boxed tab-nav-outline appear-animate">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item mr-2 mb-2">
                    <a class="nav-link active br-sm font-size-md ls-normal" href="#tab1-1">New arrivals</a>
                </li>
                <li class="nav-item mr-2 mb-2">
                    <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-2">Best seller</a>
                </li>
                <li class="nav-item mr-0 mb-2">
                    <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-3">Featured</a>
                </li>
            </ul>
        </div>
        <!-- End of Tab -->
        <div class="tab-content product-wrapper appear-animate">
            <div class="tab-pane active pt-4" id="tab1-1">
                <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">

                    @foreach($new_arrivals as $product)
                        <div class="product-wrap">
                            <div class="product text-center">
                                <figure class="product-media">
                                    <a href="{{ route('product_details', $product->slug) }}">
                                        <img class="redponsiveImg" src="{{ asset('storage/'.$product->image) }}" alt="Product"
                                             width="300" height="338"/>
                                    </a>
                                    <div class="product-action-vertical">
                                        <a href="javascript:void(0)" onclick="addWishlist('{{ $product->id }}')" class="btn-product-icon btn-wishlist {{ $product->check_wish ? 'w-icon-heart-full' : 'w-icon-heart' }}  wish_{{ $product->id }}"
                                           title="Add to wishlist"></a>
                                        <a href="{{ route('quick_view', $product->slug) }}" class="btn-product-icon quick_view w-icon-search" title="Quickview"></a>
                                        <a href="{{ route('product_details', $product->slug) }}" class="btn-product-icon btn-compare w-icon-cart"
                                           title="Add to Cart"></a>
                                    </div>
                                    @if($product->discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                        </div>
                                    @endif
                                </figure>
                                <div class="product-details">
                                    <h4 class="product-name"><a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="{{ route('product_details', $product->slug) }}" class="rating-reviews">({{ $product['rating'][0]['rating_count'] ?? 0 }} Reviews)</a>
                                    </div>
                                    <div class="product-price">
                                        @if($product->discount > 0)
                                            <ins class="new-price">{{ base_currency(). round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                            <del class="old-price">{{ base_currency().$product->price }}</del>
                                        @else
                                            <ins class="new-price">{{ base_currency().$product->price }}</ins>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
            <div class="tab-pane pt-4" id="tab1-2">
                <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                    @foreach($best_sells as $product)
                        <div class="product-wrap">
                            <div class="product text-center">
                                <figure class="product-media">
                                    <a href="{{ route('product_details', $product->slug) }}">
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="Product"
                                             width="300" height="338"/>
                                    </a>
                                    <div class="product-action-vertical">
                                        <a href="javascript:void(0)" onclick="addWishlist('{{ $product->id }}')" class="btn-product-icon btn-wishlist {{ $product->check_wish ? 'w-icon-heart-full' : 'w-icon-heart' }}  wish_{{ $product->id }}"
                                           title="Add to wishlist"></a>
                                        <a href="{{ route('quick_view', $product->slug) }}" class="btn-product-icon quick_view w-icon-search"
                                           title="Quickview"></a>
                                        <a href="{{ route('product_details', $product->slug) }}" class="btn-product-icon btn-compare w-icon-cart"
                                           title="Add to Cart"></a>
                                    </div>
                                    @if($product->discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                        </div>
                                    @endif
                                </figure>
                                <div class="product-details">
                                    <h4 class="product-name"><a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="{{ route('product_details', $product->slug) }}" class="rating-reviews">({{ $product['rating'][0]['rating_count'] ?? 0 }} Reviews)</a>
                                    </div>
                                    <div class="product-price">
                                        @if($product->discount > 0)
                                            <ins class="new-price">{{ base_currency(). round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                            <del class="old-price">{{ base_currency().$product->price }}</del>
                                        @else
                                            <ins class="new-price">{{ base_currency().$product->price }}</ins>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
            <div class="tab-pane pt-4" id="tab1-3">
                <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                    @foreach($featured_products as $product)
                        <div class="product-wrap">
                            <div class="product text-center">
                                <figure class="product-media">
                                    <a href="{{ route('product_details', $product->slug) }}">
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="Product"
                                             width="300" height="338"/>
                                    </a>
                                    <div class="product-action-vertical">
                                        <a href="javascript:void(0)" onclick="addWishlist('{{ $product->id }}')" class="btn-product-icon btn-wishlist {{ $product->check_wish ? 'w-icon-heart-full' : 'w-icon-heart' }}  wish_{{ $product->id }}"
                                           title="Add to wishlist"></a>
                                        <a href="{{ route('quick_view', $product->slug) }}" class="btn-product-icon quick_view w-icon-search"
                                           title="Quickview"></a>
                                        <a href="{{ route('product_details', $product->slug) }}" class="btn-product-icon btn-compare w-icon-cart"
                                           title="Add to Cart"></a>
                                    </div>
                                    @if($product->discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                        </div>
                                    @endif
                                </figure>
                                <div class="product-details">
                                    <h4 class="product-name"><a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="{{ route('product_details', $product->slug) }}" class="rating-reviews">({{ $product['rating'][0]['rating_count'] ?? 0 }} Reviews)</a>
                                    </div>
                                    <div class="product-price">
                                        @if($product->discount > 0)
                                            <ins class="new-price">{{ base_currency(). round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                            <del class="old-price">{{ base_currency().$product->price }}</del>
                                        @else
                                            <ins class="new-price">{{ base_currency().$product->price }}</ins>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
        </div>
        <!-- End of Tab Content -->

        @if(count($promotional_categories) > 0)
        <div class="row category-cosmetic-lifestyle appear-animate mb-5">
            @foreach($promotional_categories as $key => $promotional_category)
            <div class="col-md-6 mb-4">
                <div class="banner banner-fixed category-banner-1 br-xs">
                    <figure>
                        <img src="{{ check_image($promotional_category->image) ? asset('storage/'.$promotional_category->image) : asset('frontend/assets/images/demos/demo1/categories/3-1.jpg') }}" alt="Category Banner"
                             width="610" height="200" style="background-color: #3B4B48;" />
                    </figure>
                    <div class="banner-content y-50 pt-1">
                        <h5 class="banner-subtitle font-weight-bold text-uppercase {{ $key == 0 ? 'text-white' : 'text-dark' }}">{{ $promotional_category->title }}</h5>
                        <h3 class="banner-title font-weight-bolder text-capitalize {{ $key == 0 ? 'text-white' : 'text-dark' }}">
                            {!! nl2br($promotional_category->subtitle) !!}
                        </h3>
                        <a href="{{ route('category_product', ['category' => @$promotional_category->category->slug]) }}"
                           class="btn btn-white btn-link btn-underline btn-icon-right {{ $key == 0 ? 'text-white' : 'text-dark' }}">Shop Now<i
                                    class="w-icon-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <!-- End of Category Cosmetic Lifestyle -->


        <!-- End of Banner Fashion -->

        @if(count($home_categories) > 0)
             @php($lastKey = count($home_categories) - 1)
            @foreach($home_categories as $key => $home_category)
                    <div class="product-wrapper-1 appear-animate {{ $lastKey == $key ? 'mb-7' : 'mb-2' }}">
                        <div class="title-link-wrapper pb-1 mb-4">
                            <h2 class="title ls-normal mb-0">{{ $home_category->name }}</h2>
                            <a href="{{ route('category_product', ['category' => @$home_category->slug]) }}" class="font-size-normal font-weight-bold ls-25 mb-0">More
                                Products<i class="w-icon-long-arrow-right"></i></a>
                        </div>
                        <div class="row">
                            <!-- End of Banner -->
                            <div class="col-lg-12">
                                <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '575': {
                                        'slidesPerView': 3
                                    },
                                    '992': {
                                        'slidesPerView': 4
                                    },
                                    '1200': {
                                        'slidesPerView': 5
                                    }
                                }
                            }">
                                    <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
                                        @foreach($home_category->active_products as $product)
                                        <div class="swiper-slide product-col">
                                            <div class="product-wrap product text-center">
                                                <figure class="product-media">
                                                    <a href="{{ route('product_details', $product->slug) }}">
                                                        <img class="redponsiveImg" src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}" alt="Product"
                                                             width="216" height="243" />
                                                    </a>
                                                    <div class="product-action-vertical">
                                                        <a href="javascript:void(0)" onclick="addWishlist('{{ $product->id }}')" class="btn-product-icon btn-wishlist {{ $product->check_wish ? 'w-icon-heart-full' : 'w-icon-heart' }}  wish_{{ $product->id }}"
                                                           title="Add to wishlist"></a>
                                                        <a href="{{ route('quick_view', $product->slug) }}" class="btn-product-icon quick_view w-icon-search"
                                                           title="Quickview"></a>
                                                        <a href="{{ route('product_details', $product->slug) }}" class="btn-product-icon btn-compare w-icon-cart"
                                                           title="Add to Cart"></a>
                                                    </div>
                                                    @if($product->discount > 0)
                                                        <div class="product-label-group">
                                                            <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                                        </div>
                                                    @endif
                                                </figure>
                                                <div class="product-details">
                                                    <h4 class="product-name"><a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <a href="{{ route('product_details', $product->slug) }}" class="rating-reviews">({{ $product['rating'][0]['rating_count'] ?? 0 }} reviews)</a>
                                                    </div>
                                                    <div class="product-price">
                                                        @if($product->discount > 0)
                                                            <ins class="new-price">{{ base_currency(). round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                                            <del class="old-price">{{ base_currency().$product->price }}</del>
                                                        @else
                                                            <ins class="new-price">{{ base_currency().$product->price }}</ins>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <!-- End of Produts -->
                            </div>
                        </div>
                    </div>
            @endforeach
        <!-- End of Product Wrapper 1 -->
        @endif


        @if($coupon != null)
        <div class="banner banner-fashion appear-animate br-sm mb-9" style="background-image: url({{ asset('frontend') }}/assets/images/demos/demo1/banners/4.jpg);
            background-color: #383839;">
            <div class="banner-content align-items-center">
                <div class="content-left d-flex align-items-center mb-3">
                    <div class="banner-price-info font-weight-bolder text-secondary text-uppercase lh-1 ls-25">
                        {{ $coupon->discount }}
                        <sup class="font-weight-bold">%</sup><sub class="font-weight-bold ls-25">Off</sub>
                    </div>
                    <hr class="banner-divider bg-white mt-0 mb-0 mr-8">
                </div>
                <div class="content-right d-flex align-items-center flex-1 flex-wrap">
                    <div class="banner-info mb-0 mr-auto pr-4 mb-3">
                        <h3 class="banner-title text-white font-weight-bolder text-uppercase ls-25">
                            Minimum Purchase {{ base_currency().$coupon->min_purchase }}
                        </h3>

                        <p class="text-white mb-0">Use code
                            <span class="text-dark bg-white font-weight-bold ls-50 pl-1 pr-1 d-inline-block">
                                    <strong>{{ $coupon->code }}</strong></span> to get best offer.
                        </p>
                    </div>
                    <a href="{{ route('view_cart') }}"
                       class="btn btn-white btn-outline btn-rounded btn-icon-right mb-3">Apply Coupon</a>
                </div>
            </div>
        </div>
        @endif

        <h2 class="title title-underline mb-4 ls-normal appear-animate">Our Clients</h2>
        <div class="swiper-container swiper-theme brands-wrapper mb-9 appear-animate" data-swiper-options="{
                    'spaceBetween': 0,
                    'slidesPerView': 2,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 3
                        },
                        '768': {
                            'slidesPerView': 4
                        },
                        '992': {
                            'slidesPerView': 5
                        },
                        '1200': {
                            'slidesPerView': 6
                        }
                    }
                }">
            <div class="swiper-wrapper row gutter-no cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                @foreach($brand_chunk as $brands)
                <div class="swiper-slide ">
                    @foreach($brands as $brand)
                    <figure class="brand-wrapper">
                        <img src="{{ asset('storage/'.$brand->image) }}" alt="Brand" width="410"
                             height="186" />
                    </figure>
                   @endforeach
                </div>
                @endforeach
            </div>
        </div>
        <!-- End of Brands Wrapper -->

         @if(count($videos) > 0)
        <div class="post-wrapper appear-animate mb-4">
            <div class="title-link-wrapper pb-1 mb-4">
                <h2 class="title ls-normal mb-0">From Our Videos</h2>
                <a href="{{ route('videos') }}" class="font-weight-bold font-size-normal">View All Videos</a>
            </div>

            <div class="swiper">
                <div class="swiper-container swiper-theme" data-swiper-options="{
                            'slidesPerView': 1,
                            'spaceBetween': 20,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 2
                                },
                                '768': {
                                    'slidesPerView': 3
                                },
                                '992': {
                                    'slidesPerView': 4
                                }
                            }
                        }">

                    <div class="swiper-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-1">
                        @foreach($videos as $video)
                        <div class="swiper-slide post text-center overlay-zoom">
                            <figure class="post-media br-sm">
                                <a>
                                    <img src="{{ asset('storage/'.$video->image) }}" alt="Post" width="280"
                                         height="180" style="background-color: #4b6e91;" />
                                    <a  href="{{ $video->youtube_url }}" class="playBtn playVideo">
                                        <i class="fas fa-play platIcon"></i>
                                    </a>
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by {{ $video->post_by }} - {{ date('d.m.Y', strtotime($video->created_at)) }}
                                </div>
                                <h4 class="post-title">{{ $video->title }}</h4>
                                <a href="{{ $video->youtube_url }}" class="btn btn-link btn-dark btn-underline playVideo">Play Video<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <!-- Post Wrapper -->
        @endif
    <!--End of Catainer -->
        </div>

    </main>
@endsection

@push('js')

@endpush
