<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>@yield('title') - {{ get_settings('website_name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/assets/images/icons/favicon.png">


    <meta name="author" content="{{ get_settings('website_name') }}">
    <meta name="robots" content="index, follow">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', get_settings('meta_description'))">
    <meta name="keywords" content="@yield('keywords', get_settings('meta_keywords'))">

    <!-- Open Graph and Twitter Cards -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', get_settings('website_name'))">
    <meta property="og:description" content="@yield('og_description', get_settings('meta_description'))">
    <meta property="og:image" content="@yield('og_image', asset('storage/'.get_settings('logo')))">
    <meta property="og:url" content="@yield('og_url', url()->current())">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', get_settings('website_name'))">
    <meta name="twitter:description" content="@yield('twitter_description', get_settings('meta_description'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('storage/'.get_settings('logo')))">
    <meta name="twitter:url" content="@yield('twitter_url', url()->current())">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical_url', url()->current())">



    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: { families: ['Poppins:400,500,600,700,800'] }
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{ asset('frontend') }}/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <link rel="preload" href="{{ asset('frontend') }}/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" href="{{ asset('frontend') }}/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" href="{{ asset('frontend') }}/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" href="{{ asset('frontend') }}/assets/fonts/wolmart.woff?png09e" as="font" type="font/woff" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/vendor/fontawesome-free/css/all.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/vendor/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/vendor/magnific-popup/magnific-popup.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.css">

    <!-- Default CSS -->
    @if(request()->is('/'))
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/demo1.min.css">
    @else
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style.min.css">
    @endif

    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">

    @stack('css')

    <script src="{{ asset('frontend') }}/assets/vendor/jquery/jquery.min.js"></script>

</head>

<body>
<div class="page-wrapper {{ request()->is('user/*') ? 'my-account' : '' }}">
    <!-- Start of Header -->
    @include('layouts.frontend.partials.header')
    <!-- End of Header -->

    <!-- Start of Main-->
    @yield('content')
    <!-- End of Main -->

    <!-- Start of Footer -->
    @include('layouts.frontend.partials.footer')
    <!-- End of Footer -->
</div>
<!-- End of Page-wrapper-->

<!-- Start of Sticky Footer -->
<div class="sticky-footer sticky-content fix-bottom">
    <a href="{{ url('/') }}" class="sticky-link active">
        <i class="w-icon-home"></i>
        <p>Home</p>
    </a>
    <a href="{{ route('category_product') }}" class="sticky-link">
        <i class="w-icon-category"></i>
        <p>Shop</p>
    </a>
    <a href="{{ route('view_cart') }}" class="sticky-link">
        <i class="w-icon-cart"></i>
        <p>Cart</p>
    </a>
    <a href="{{ route('user.dashboard') }}" class="sticky-link">
        <i class="w-icon-account"></i>
        <p>Account</p>
    </a>

</div>
<!-- End of Sticky Footer -->

<!-- Start of Scroll Top -->
<a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button"> <i class="w-icon-angle-up"></i> <svg
            version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
        <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35"
                r="34" style="stroke-dasharray: 16.4198, 400;"></circle>
    </svg> </a>
<!-- End of Scroll Top -->



<!-- Start of Newsletter popup -->
<div class="newsletter-popup mfp-hide">
    <div class="newsletter-content">
        <h4 class="text-uppercase font-weight-normal ls-25">Get Up to<span class="text-primary">25% Off</span></h4>
        <h2 class="ls-25">Sign up to Wolmart</h2>
        <p class="text-light ls-10">Subscribe to the Wolmart market newsletter to
            receive updates on special offers.</p>
        <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
            <input type="email" class="form-control email font-size-md" name="email" id="email2"
                   placeholder="Your email address" required="">
            <button class="btn btn-dark" type="submit">SUBMIT</button>
        </form>
        <div class="form-checkbox d-flex align-items-center">
            <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup" name="hide-newsletter-popup"
                   required="">
            <label for="hide-newsletter-popup" class="font-size-sm text-light">Don't show this popup again.</label>
        </div>
    </div>
</div>
<!-- End of Newsletter popup -->

<!-- Start of Quick View -->
<div class="product product-single product-popup">
    <div class="row gutter-lg">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="product-gallery product-gallery-sticky">
                <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                    <div class="swiper-wrapper row cols-1 gutter-no">
                        <div class="swiper-slide">
                            <figure class="product-image">
                                <img src="{{ asset('frontend') }}/assets/images/products/popup/1-440x494.jpg"
                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/popup/1-800x900.jpg"
                                     alt="Water Boil Black Utensil" width="800" height="900">
                            </figure>
                        </div>
                        <div class="swiper-slide">
                            <figure class="product-image">
                                <img src="{{ asset('frontend') }}/assets/images/products/popup/2-440x494.jpg"
                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/popup/2-800x900.jpg"
                                     alt="Water Boil Black Utensil" width="800" height="900">
                            </figure>
                        </div>
                        <div class="swiper-slide">
                            <figure class="product-image">
                                <img src="{{ asset('frontend') }}/assets/images/products/popup/3-440x494.jpg"
                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/popup/3-800x900.jpg"
                                     alt="Water Boil Black Utensil" width="800" height="900">
                            </figure>
                        </div>
                        <div class="swiper-slide">
                            <figure class="product-image">
                                <img src="{{ asset('frontend') }}/assets/images/products/popup/4-440x494.jpg"
                                     data-zoom-image="{{ asset('frontend') }}/assets/images/products/popup/4-800x900.jpg"
                                     alt="Water Boil Black Utensil" width="800" height="900">
                            </figure>
                        </div>
                    </div>
                    <button class="swiper-button-next"></button>
                    <button class="swiper-button-prev"></button>
                </div>
                <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                        'navigation': {
                            'nextEl': '.swiper-button-next',
                            'prevEl': '.swiper-button-prev'
                        }
                    }">
                    <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                        <div class="product-thumb swiper-slide">
                            <img src="{{ asset('frontend') }}/assets/images/products/popup/1-103x116.jpg" alt="Product Thumb" width="103"
                                 height="116">
                        </div>
                        <div class="product-thumb swiper-slide">
                            <img src="{{ asset('frontend') }}/assets/images/products/popup/2-103x116.jpg" alt="Product Thumb" width="103"
                                 height="116">
                        </div>
                        <div class="product-thumb swiper-slide">
                            <img src="{{ asset('frontend') }}/assets/images/products/popup/3-103x116.jpg" alt="Product Thumb" width="103"
                                 height="116">
                        </div>
                        <div class="product-thumb swiper-slide">
                            <img src="{{ asset('frontend') }}/assets/images/products/popup/4-103x116.jpg" alt="Product Thumb" width="103"
                                 height="116">
                        </div>
                    </div>
                    <button class="swiper-button-next"></button>
                    <button class="swiper-button-prev"></button>
                </div>
            </div>
        </div>
        <div class="col-md-6 overflow-hidden p-relative">
            <div class="product-details scrollable pl-0">
                <h2 class="product-title">Electronics Black Wrist Watch</h2>
                <div class="product-bm-wrapper">
                    <figure class="brand">
                        <img src="{{ asset('frontend') }}/assets/images/products/brand/brand-1.jpg" alt="Brand" width="102" height="48" />
                    </figure>
                    <div class="product-meta">
                        <div class="product-categories">
                            Category:
                            <span class="product-category"><a href="#">Electronics</a></span>
                        </div>
                        <div class="product-sku">
                            SKU: <span>MS46891340</span>
                        </div>
                    </div>
                </div>

                <hr class="product-divider">

                <div class="product-price">$40.00</div>

                <div class="ratings-container">
                    <div class="ratings-full">
                        <span class="ratings" style="width: 80%;"></span>
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <a href="#" class="rating-reviews">(3 Reviews)</a>
                </div>

                <div class="product-short-desc">
                    <ul class="list-type-check list-style-none">
                        <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                        <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                        <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                    </ul>
                </div>

                <hr class="product-divider">

                <div class="product-form product-variation-form product-color-swatch">
                    <label>Color:</label>
                    <div class="d-flex align-items-center product-variations">
                        <a href="#" class="color" style="background-color: #ffcc01"></a>
                        <a href="#" class="color" style="background-color: #ca6d00;"></a>
                        <a href="#" class="color" style="background-color: #1c93cb;"></a>
                        <a href="#" class="color" style="background-color: #ccc;"></a>
                        <a href="#" class="color" style="background-color: #333;"></a>
                    </div>
                </div>
                <div class="product-form product-variation-form product-size-swatch">
                    <label class="mb-1">Size:</label>
                    <div class="flex-wrap d-flex align-items-center product-variations">
                        <a href="#" class="size">Small</a>
                        <a href="#" class="size">Medium</a>
                        <a href="#" class="size">Large</a>
                        <a href="#" class="size">Extra Large</a>
                    </div>
                    <a href="#" class="product-variation-clean">Clean All</a>
                </div>

                <div class="product-variation-price">
                    <span></span>
                </div>

                <div class="product-form">
                    <div class="product-qty-form">
                        <div class="input-group">
                            <input class="quantity form-control" type="number" min="1" max="10000000">
                            <button class="quantity-plus w-icon-plus"></button>
                            <button class="quantity-minus w-icon-minus"></button>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-cart">
                        <i class="w-icon-cart"></i>
                        <span>Add to Cart</span>
                    </button>
                </div>

                <div class="social-links-wrapper">
                    <div class="social-links">
                        <div class="social-icons social-no-color border-thin">
                            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                            <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>
                            <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                            <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                        </div>
                    </div>
                    <span class="divider d-xs-show"></span>
                    <div class="product-link-wrapper d-flex">
                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                        <a href="#"
                           class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Quick view -->


<div class="mfp-hide" id="main_modal" tabindex="-1" style="padding: 30px 30px; max-width: 700px; border-radius: 10px">
    <div class="">
        <h4 class="modal-title">Title</h4>
        <hr>

        <div class="modal-body">

        </div>

    </div>


</div>

<!-- Plugin JS File -->

<script src="{{ asset('frontend') }}/assets/vendor/jquery.plugin/jquery.plugin.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/zoom/jquery.zoom.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/jquery.countdown/jquery.countdown.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/skrollr/skrollr.min.js"></script>

<!-- Swiper JS -->
<script src="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS -->
<script src="{{ asset('frontend') }}/assets/js/main.min.js"></script>

<script src="{{ asset('js/iziToast.js') }}"></script>
@include('vendor.lara-izitoast.toast')

<script>
    $(document).ready(function () {
        $(".ajax-modal").on('click', function () {
            var link = $(this).attr("href");
            var title = $(this).data("title");

            $.ajax({
                url: link,
                success: function(data){
                    $('#main_modal .modal-body').html(data);
                    $('#main_modal .modal-title').html(title);
                    Wolmart.popup({
                        items: { src: "#main_modal" },
                        type: "inline",
                        tLoading: "",
                    });

                }
            });
            return false;
        })
    });
</script>

<script>
    function scrollToDiv() {
        const element = document.getElementById('hotDeals');
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        } else {
            iziToast.warning({
                message: 'Daily Deals section not found. Please check back later for exciting offers!',
            });
        }
    }
</script>

@stack('js')

</body>

</html>
