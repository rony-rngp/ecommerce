@extends('layouts.frontend.app')

@section('title', $product->name)

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
                                                                 alt="Electronics Black Wrist Watch" width="800" height="900">
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            @else

                                                <div class="swiper-slide">
                                                    <figure class="product-image">
                                                        <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                             data-zoom-image="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                             alt="Electronics Black Wrist Watch" width="800" height="900">
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
                                            <span class="ratings" style="width: 80%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="#product-tab-reviews" class="rating-reviews scroll-to">(3
                                            Reviews)</a>
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
                                                    <span id="active_color_{{ $product_color->color_name }}" onclick="setColor('{{ $product_color->color_name }}')" class="color set_color" title="{{ $product_color->color_name }}" style="cursor: pointer; background-color: {{ $product_color->color_code }}"></span>
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
                                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                <a href="#"
                                                   class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                <a href="#"
                                                   class="social-icon social-youtube fab fa-linkedin-in"></a>
                                            </div>
                                        </div>
                                        <span class="divider d-xs-show"></span>
                                        <div class="product-link-wrapper d-flex">
                                            <a href="#"
                                               class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                            <a href="#"
                                               class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
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
                                    <a href="#product-tab-reviews" class="nav-link">Customer Reviews (3)</a>
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
                                                    <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                                                    <div class="avg-rating">
                                                        <p class="text-dark mb-1">Average Rating</p>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 60%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="#" class="rating-reviews">(3 Reviews)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="ratings-value d-flex align-items-center text-dark ls-25">
                                                        <span
                                                            class="text-dark font-weight-bold">66.7%</span>Recommended<span
                                                        class="count">(2 of 3)</span>
                                                </div>
                                                <div class="ratings-list">
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 100%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>70%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 80%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>30%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 60%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>40%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 40%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>0%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 20%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>0%</mark>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-7 mb-4">
                                            <div class="review-form-wrapper">
                                                <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your
                                                    Review</h3>
                                                <p class="mb-3">Your email address will not be published. Required
                                                    fields are marked *</p>
                                                <form action="#" method="POST" class="review-form">
                                                    <div class="rating-form">
                                                        <label for="rating">Your Rating Of This Product :</label>
                                                        <span class="rating-stars">
                                                                <a class="star-1" href="#">1</a>
                                                                <a class="star-2" href="#">2</a>
                                                                <a class="star-3" href="#">3</a>
                                                                <a class="star-4" href="#">4</a>
                                                                <a class="star-5" href="#">5</a>
                                                            </span>
                                                        <select name="rating" id="rating" required=""
                                                                style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <textarea cols="30" rows="6"
                                                              placeholder="Write Your Review Here..." class="form-control"
                                                              id="review"></textarea>
                                                    <div class="row gutter-md">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Your Name" id="author">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Your Email" id="email_1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" class="custom-checkbox"
                                                               id="save-checkbox">
                                                        <label for="save-checkbox">Save my name, email, and website
                                                            in this browser for the next time I comment.</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-dark">Submit
                                                        Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a href="#show-all" class="nav-link active">Show All</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#helpful-positive" class="nav-link">Most Helpful
                                                    Positive</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#helpful-negative" class="nav-link">Most Helpful
                                                    Negative</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#highest-rating" class="nav-link">Highest Rating</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#lowest-rating" class="nav-link">Lowest Rating</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="show-all">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/1-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 60%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-1.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-1-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/2-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 80%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-2.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-2.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-3.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-3.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/3-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:21 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 60%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                    condimentum vitae
                                                                    sapien pellentesque habitant morbi tristique
                                                                    senectus et. In dictum
                                                                    non consectetur a erat. Nunc scelerisque viverra
                                                                    mauris in aliquam sem fringilla.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (1)
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="helpful-positive">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/1-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 60%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-1.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-1.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/2-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 80%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-2.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-2-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-3.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="helpful-negative">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/3-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:21 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 60%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                    condimentum vitae
                                                                    sapien pellentesque habitant morbi tristique
                                                                    senectus et. In dictum
                                                                    non consectetur a erat. Nunc scelerisque viverra
                                                                    mauris in aliquam sem fringilla.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (1)
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="highest-rating">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/2-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 80%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-2.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-2-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-3.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="lowest-rating">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="{{ asset('frontend') }}/assets/images/agents/1-100x100.png"
                                                                     alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                  style="width: 60%;"></span>
                                                                        <span
                                                                            class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                       class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                       class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="{{ asset('frontend') }}/assets/images/products/default/review-img-3.jpg"
                                                                                     width="60" height="60"
                                                                                     alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section class="related-product-section">
                            <div class="title-link-wrapper mb-4">
                                <h4 class="title">Related Products</h4>
                                <a href="#" class="btn btn-dark btn-link btn-slide-right btn-icon-right">More
                                    Products<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <div class="swiper-container swiper-theme" data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 3
                                        }
                                    }
                                }">
                                <div class="swiper-wrapper row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                                    <div class="swiper-slide product">
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{ asset('frontend') }}/assets/images/products/default/5.jpg" alt="Product"
                                                     width="300" height="338" />
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                   title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                   title="Add to wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                   title="Add to Compare"></a>
                                            </div>
                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                    View</a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="product-default.html">Drone</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">$632.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product">
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{ asset('frontend') }}/assets/images/products/default/6.jpg" alt="Product"
                                                     width="300" height="338" />
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                   title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                   title="Add to wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                   title="Add to Compare"></a>
                                            </div>
                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                    View</a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="product-default.html">Official Camera</a>
                                            </h4>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <ins class="new-price">$263.00</ins><del
                                                        class="old-price">$300.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product">
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{ asset('frontend') }}/assets/images/products/default/7-1.jpg" alt="Product"
                                                     width="300" height="338" />
                                                <img src="{{ asset('frontend') }}/assets/images/products/default/7-2.jpg" alt="Product"
                                                     width="300" height="338" />
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                   title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                   title="Add to wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                   title="Add to Compare"></a>
                                            </div>
                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                    View</a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="product-default.html">Phone Charge Pad</a>
                                            </h4>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 80%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(8 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">$23.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product">
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{ asset('frontend') }}/assets/images/products/default/8.jpg" alt="Product"
                                                     width="300" height="338" />
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                   title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                   title="Add to wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                   title="Add to Compare"></a>
                                            </div>
                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                    View</a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="product-default.html">Fashionalble
                                                    Pencil</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(9 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">$50.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
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
                                            <p> In Dhaka 100 and outside 150</p>
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
                                                <i class="w-icon-money"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Money Back Guarantee</h4>
                                            <p>Any back within 30 days</p>
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
                                                <div class="widget-col swiper-slide">
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/13.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">Smart Watch</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 100%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$80.00 - $90.00</div>
                                                        </div>
                                                    </div>
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/14.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">Sky Medical Facility</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 80%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$58.00</div>
                                                        </div>
                                                    </div>
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/15.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">Black Stunt Motor</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 60%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$374.00</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-col swiper-slide">
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/16.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">Skate Pan</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 100%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$278.00</div>
                                                        </div>
                                                    </div>
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/17.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">Modern Cooker</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 80%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$324.00</div>
                                                        </div>
                                                    </div>
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="#">
                                                                <img src="{{ asset('frontend') }}/assets/images/shop/18.jpg" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="#">CT Machine</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 100%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">$236.00</div>
                                                        </div>
                                                    </div>
                                                </div>
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
