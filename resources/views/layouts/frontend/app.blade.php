<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>@yield('title') - {{ get_settings('website_name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/'.get_settings('favicon')) }}">


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

    <style>
        #youtebePop iframe{
            margin-bottom: -10px !important;
        }
        @media (max-width: 576px) {
            #youtebePop iframe{
                height: 300px;
            }
        }
    </style>

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
<div id="quickViewProduct" class="product product-single product-popup">

</div>
<!-- End of Quick view -->

<!-- Start of Quick View -->
<div class="mfp-hide" id="youtebePop" style="padding: 0px 0px; max-width: 700px; border-radius: 10px">

</div>
<!-- End of Quick view -->


<div class="mfp-hide" id="main_modal" tabindex="-1" style="padding: 30px 30px; max-width: 600px; border-radius: 10px">
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
        });

        $(".quick_view").on('click', function () {
            var link = $(this).attr("href");
            var title = $(this).data("title");

            $.ajax({
                url: link,
                success: function(data){

                    $("#quickViewProduct").html(data);

                    Wolmart.popup(
                        {
                            items: { src: $("#quickViewProduct")[0].outerHTML },
                            callbacks: {
                                open: function () {
                                    Wolmart.productSingle($(".mfp-product .product-single"));
                                },
                                close: function () {
                                    $(".mfp-product .swiper-container").each(function () {
                                        if (this.swiper) {
                                            this.swiper.destroy(true, true);
                                        }
                                    });
                                }
                            }
                        },
                        "quickview"
                    );

                }
            });
            return false;
        });

        $(".playVideo").on('click', function () {
            var link = $(this).attr("href");

            var videoId = link.split('v=')[1].split('&')[0];

            var fram = '<iframe id="youtube-video" src="https://www.youtube.com/embed/'+videoId+'?rel=0" width="100%" height="400" style="margin-bottom:-9px;" frameborder="0" \n' +
                ' allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" \n' +
                ' allowfullscreen>\n' +
                '</iframe>';

            $("#youtebePop").html(fram);

            Wolmart.popup({
                items: { src: "#youtebePop" },
                type: "inline",
                tLoading: "",
            });

            return false;
        });

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


    function addWishlist(productID) {
        $.ajax({
            url : "{{ route('wishlist.store') }}",
            type : "get",
            data : {product_id:productID},
            success:function (res) {
                if(res.status == true){
                    if(res['type'] == 'add'){
                        $(".wish_"+productID).removeClass('w-icon-heart');
                        $(".wish_"+productID).addClass('w-icon-heart-full');
                        iziToast.success({
                            title: 'Success',
                            message: 'Added in wishlist',
                            position: "topRight",
                        });
                    }else{
                        $(".wish_"+productID).removeClass('w-icon-heart-full');
                        $(".wish_"+productID).addClass('w-icon-heart');
                        iziToast.success({
                            title: 'Success',
                            message: 'Removed from wishlist',
                            position: "topRight",
                        });
                    }
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

@stack('js')

</body>

</html>
