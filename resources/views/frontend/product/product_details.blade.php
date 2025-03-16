@extends('layouts.frontend.app')

@section('title', $product->name)
@section('og_title', $product->name)
@section('twitter_title', $product->name)
@section('description', $product->short_description)
@section('og_description', $product->short_description)
@section('twitter_description', $product->short_description)
@section('og_image', asset('storage/'.$product->image))
@section('twitter_image', asset('storage/'.$product->image))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/vendor/photoswipe/photoswipe.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/vendor/photoswipe/default-skin/default-skin.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style.min.css">
@endpush

@section('content')

    <main class="main mb-10 pb-1">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Products</li>
            </ul>

        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row gutter-lg">
                    <div class="main-content">
                        <div class="product product-single row">
                            <div class="col-md-6 mb-6">
                                <div class="product-gallery product-gallery-sticky">
                                    <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                        <div class="swiper-wrapper row cols-1 gutter-no">
                                            @if($product->product_galleries != null && count($product->product_galleries) > 0)
                                                @foreach($product->product_galleries ?? [] as $gellery)
                                                    <div class="swiper-slide">
                                                        <figure class="product-image">
                                                            <img src="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                                 data-zoom-image="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                                 alt="{{ $product->name }}" width="800" height="900">
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            @else

                                                <div class="swiper-slide">
                                                    <figure class="product-image">
                                                        <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                             data-zoom-image="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                             alt="{{ $product->name }}" width="800" height="900">
                                                    </figure>
                                                </div>
                                            @endif
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                        <a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>
                                    </div>
                                    <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                        <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                            @if($product->product_galleries != null && count($product->product_galleries) > 0)
                                                @foreach($product->product_galleries ?? [] as $gellery)
                                                    <div class="product-thumb swiper-slide">
                                                        <img src="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                             alt="Product Thumb" width="800" height="900">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="product-thumb swiper-slide">
                                                    <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                         alt="Product Thumb" width="800" height="900">
                                                </div>
                                            @endif
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 mb-md-6">
                                <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                    <h1 class="product-title">{{ $product->name }}</h1>
                                    <div class="product-bm-wrapper">
                                        <figure class="brand">
                                            <img src="{{ check_image(@$product->brand->image) ? asset('storage/'. @$product->brand->image) : asset('frontend/assets/images/products/brand/brand-1.jpg') }}" alt="Brand"
                                                 width="102" height="48" />
                                        </figure>
                                        <div class="product-meta">
                                            <div class="product-categories">
                                                Category:
                                                <span class="product-category">
                                                    <a href="#">{{ @$product->category->name ?? 'N/A' }} @if($product->subcategory != null) > {{$product->subcategory->name}}@endif</a>
                                                </span>
                                            </div>
                                            <div class="product-sku">
                                                SKU: <span>{{ $product->sku }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="product-divider">

                                    <div class="product-price">
                                        @if($product->discount > 0)
                                            <ins id="new_price" class="new-price">{{ base_currency().round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                            <del id="old_price" class="old-price">{{ base_currency().$product->price }}</del>
                                        @else
                                            <ins id="new_price" class="new-price">{{ base_currency().$product->price }}</ins>
                                        @endif
                                    </div>

                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="#product-tab-reviews" class="rating-reviews scroll-to">({{ $product->rating[0]['rating_count'] ?? 0 }}
                                            Reviews)</a>
                                    </div>

                                    <div style="font-weight: bold; font-size: 14px" class="bold mb-2">
                                        STOCK : <span class="showStock">
                                            @if($product->has_attribute == 1)
                                                {{  @$product->attributes->sum('stock') > 0 ?  @$product->attributes->sum('stock') : 'Out Of Stock' }}
                                            @else
                                                {{ $product->stock > 0 ? $product->stock : 'Out Of Stock' }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="product-short-desc">
                                        {!! nl2br($product->short_description) !!}
                                    </div>

                                    <hr class="product-divider">

                                    <form id="cartForm" action="{{ route('add_to_card', $product->id) }}" method="post">
                                        @csrf
                                        @if(count($product->product_colors) > 0)
                                            <div class="product-form product-variation-form product-color-swatch">
                                                <label>Color:</label>
                                                <div class="d-flex align-items-center product-variations">
                                                    @foreach($product->product_colors as $product_color)
                                                    <span id="active_color_{{ $product_color->color_name }}" onclick="setColor('{{ $product_color->color_name }}')" class="color set_color" title="{{ $product_color->color_name }}" style="cursor: pointer; background-color: {{ $product_color->color_code }}; border: 1px solid"></span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="d-block" style="color: red">{{ $errors->has('color_name') ? $errors->first('color_name') : '' }}</span>

                                            <input type="hidden" name="color_name" id="color_name">
                                        @endif


                                        @if($product->has_attribute == 1 && count($product->attributes) > 0)
                                            <div class="product-form product-variation-form product-size-swatch">
                                                <label class="mb-1">{{ $product->attribute_title }}:</label>
                                                <div class="flex-wrap d-flex align-items-center product-variations">
                                                    @foreach($product->attributes ?? [] as $product_attribute)
                                                    <a style="cursor: pointer" id="active_attr_{{ $product_attribute->id }}" onclick="setAttr('{{ $product_attribute->id }}', '{{ $product_attribute->attribute }}', '{{ $product_attribute->price }}', '{{ $product_attribute->stock }}')" class="size set_attr">{{ $product_attribute->attribute }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="d-block" style="color: red">{{ $errors->has('attribute') ? $errors->first('attribute') : '' }}</span>
                                            <input type="hidden" name="attribute" id="attribute">
                                        @endif

                                        <div class="fix-bottom product-sticky-content sticky-content">
                                            <div class="product-form container">
                                                <div class="product-qty-form">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" required name="quantity" type="number" min="1"
                                                               max="100">
                                                        <button type="button" class="quantity-plus w-icon-plus"></button>
                                                        <button type="button" class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-cart">
                                                    <i class="w-icon-cart"></i>
                                                    <span>Add to Cart</span>
                                                </button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="social-links-wrapper">
                                        <div class="social-links">
                                            <div class="social-icons social-no-color border-thin">
                                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-icon social-facebook w-icon-facebook"></a>
                                                <a target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode('Check this out!') }}" class="social-icon social-twitter w-icon-twitter"></a>
                                                <a target="_blank" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(asset('storage/'.$product->image)) }}&description={{ urlencode('Check this out!') }}"
                                                   class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                <a target="_blank" href="https://api.whatsapp.com/send?text={{ urlencode('Check this out! ') . urlencode(url()->current()) }}" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}"
                                                   class="social-icon social-youtube fab fa-linkedin-in"></a>
                                            </div>
                                        </div>
                                        <span class="divider d-xs-show"></span>
                                        <div class="product-link-wrapper d-flex">
                                            <a href="#"
                                               class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#product-tab-description" class="nav-link active">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product-tab-reviews" class="nav-link">Customer Reviews ({{ $product->rating[0]['rating_count'] ?? 0 }})</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-tab-description">
                                    <div>
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane" id="product-tab-reviews">
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-5 mb-4">
                                            <div class="ratings-wrapper">
                                                <div class="avg-rating-container">
                                                    <h4 class="avg-mark font-weight-bolder ls-50">{{ $product->rating[0]['average'] ?? 0 }}</h4>
                                                    <div class="avg-rating">
                                                        <p class="text-dark mb-1">Average Rating</p>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: {{ ($product->getRatingPercentage()) }}%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="#" class="rating-reviews">({{ $product->rating[0]['rating_count'] ?? 0 }} Reviews)</a>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        @if($review_info['is_review'] == true && Auth::check())
                                        <div class="col-xl-8 col-lg-7 mb-4">
                                            <div class="review-form-wrapper">
                                                <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your Review</h3>
                                                    <form action="{{ route('user.store_review') }}" method="POST" class="review-form">
                                                    @csrf
                                                        <select name="ratings" class="form-control mt-3" required="">
                                                            <option value="5">★★★★★ - Excellent</option>
                                                            <option value="4">★★★★ - Very Good</option>
                                                            <option value="3">★★★ - Good</option>
                                                            <option value="2">★★ - Fair</option>
                                                            <option value="1">★ - Poor</option>
                                                        </select>
                                                        <input type="hidden" name="product_id" value="{{ Crypt::encrypt($product->id) }}">
                                                        <select name="order_id" class="form-control" required>
                                                            @foreach($review_info['order_info'] ?? [] as $order_info)
                                                                <option value="{{ $order_info->order_id }}">Order ID : {{ $order_info->order_id }}</option>
                                                            @endforeach
                                                        </select>
                                                        <textarea cols="30" rows="6" name="review" required
                                                                  placeholder="Write Your Review Here..." class="form-control"
                                                                  id="review"></textarea>


                                                        <button type="submit" class="btn btn-dark">Submit
                                                            Review</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="show-all">
                                                <ul class="comments list-style-none">
                                                    @foreach($product->reviews ?? [] as $review)
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('backend/assets/img/avater.jpeg') }}"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="javascript:void(0)">{{ @$review->user->name }}</a>
                                                                    <span class="comment-date">{{ date('F j, Y \a\t g:i a', strtotime($review->created_at)) }}</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings" style="width: {{ getAvg($review->rating) }}%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <div>{!! nl2br($review->review) !!}</div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                   @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Main Content -->
                    <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                        <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                        <div class="sidebar-content scrollable">
                            <div class="sticky-sidebar">
                                <div class="widget widget-icon-box mb-6">
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-truck"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Shipping Charge</h4>
                                            <p> In Dhaka {{ get_settings('in_dhaka').' '.base_currency_name() }} and outside {{ get_settings('outside_dhaka').' '.base_currency_name() }}</p>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-bag"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Secure Payment</h4>
                                            <p>We ensure secure payment</p>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-chat"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Customer Support</h4>
                                            <p>Call or email us 24/7</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="widget widget-products">
                                    <div class="title-link-wrapper mb-2">
                                        <h4 class="title title-link font-weight-bold">More Products</h4>
                                    </div>

                                    <div class="swiper nav-top">
                                        <div class="swiper-container swiper-theme nav-top" data-swiper-options = "{
                                                'slidesPerView': 1,
                                                'spaceBetween': 20,
                                                'navigation': {
                                                    'prevEl': '.swiper-button-prev',
                                                    'nextEl': '.swiper-button-next'
                                                }
                                            }">
                                            <div class="swiper-wrapper">
                                                @foreach($chunked_more_products as $more_products)
                                                <div class="widget-col swiper-slide">
                                                    @foreach($more_products as $more_product)
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ check_image($more_product->image) ? asset('storage/'.$more_product->image): '' }}" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="{{ route('product_details', $more_product->slug) }}">{{ $more_product->name }}</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: {{ getAvg($more_product['rating'][0]['average'] ?? 0) }}%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">{{ base_currency().$more_product->price }}</div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- End of Sidebar -->
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
    </main>


    <!-- Root element of PhotoSwipe. Must have class pswp -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides.
			PhotoSwipe keeps only 3 of them in the DOM to save memory.
			Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>

                    <div class="pswp__preloader">
                        <div class="loading-spin"></div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
                <button class="pswp__button--arrow--right" aria-label="Next (arrow right)"></button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PhotoSwipe -->

@endsection

@push('js')
    <script src="{{ asset('frontend') }}/assets/vendor/photoswipe/photoswipe.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/photoswipe/photoswipe-ui-default.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/sticky/sticky.js"></script>

    <script>

        let has_attribute = "{{ $product->has_attribute == 1 ? true : false }}";
        let attribute_title = "{{ $product->attribute_title }}";
        let has_color = "{{ count($product->product_colors) > 0 ? true : false }}";

        $('#cartForm').submit(function(event) {
            if(has_color == 1){
                let color = $("#color_name").val();
                if(color == ''){
                    iziToast.error({
                        title: 'Error',
                        message: 'Please select a color',
                        position: "topRight",
                    });
                    return false;
                }
            }
            if(has_attribute == 1){
                let attr = $("#attribute").val();
                if(attr == ''){
                    iziToast.error({
                        title: 'Error',
                        message: 'Please select a '+attribute_title,
                        position: "topRight",
                    });
                    return false;
                }
            }
            return true;
        });

        function setColor(color_name) {
            $(".set_color").removeClass('active');
            $("#active_color_"+color_name).addClass('active');
            $("#color_name").val(color_name);
        }


        const product_discount = parseInt('{{ $product->discount }}');
        const base_currency = '{{base_currency()}}';

        function setAttr(attr_id, attr_name, attr_price, stock) {

            {{--if(stock < 1){--}}
            {{--    alert('Sorry, This {{ $product->attribute_title }} out of stock');--}}
            {{--    return false;--}}
            {{--}--}}
            if(stock > 0){
                $(".showStock").html(stock);
            }else{
                $(".showStock").html('Out Of Stock');
            }


            $(".set_attr").removeClass('active');
            $("#active_attr_"+attr_id).addClass('active');
            $("#attribute").val(attr_name);

            const attr_price_float = parseFloat(attr_price);
            if(product_discount > 0){
                let new_price = attr_price_float - ((product_discount/100)*attr_price_float) ;
                new_price = Math.round(new_price);
                $("#new_price").text(base_currency+new_price);
                $("#old_price").text(base_currency+attr_price);
            }else{
                $("#new_price").text(base_currency+attr_price);
            }
        }
    </script>

@endpush
