<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <p class="welcome-msg">Welcome to {{ get_settings('website_name') }} Store</p>
            </div>
            <div class="header-right">
                <div class="dropdown">
                    <a href="javascript:void(0)">{{ base_currency_name() }}</a>
                   {{-- <div class="dropdown-box">
                        <a href="#USD">USD</a>
                        <a href="#EUR">EUR</a>
                    </div>--}}
                </div>
                <!-- End of DropDown Menu -->

                <!-- End of Dropdown Menu -->
                <span class="divider d-lg-show"></span>
                <a href="#" class="d-lg-show">Contact Us</a>
                @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{ route('user.dashboard') }}" class="d-lg-show">My Account</a>
                <a href="{{ route('user.dashboard') }}" class="d-lg-show">Balance: {{ base_currency().auth()->user()->balance }}</a>
                @else
                <a href="{{ route('login') }}" class="d-lg-show login sign-in"><iclass="w-icon-account"></i>Sign In</a>
                <span class="delimiter d-lg-show">/</span>
                <a href="{{ route('register') }}" class="ml-0 d-lg-show login register">Register</a>
                @endif
            </div>
        </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left mr-md-4">
                <a href="#" class="mobile-menu-toggle  w-icon-hamburger" aria-label="menu-toggle">
                </a>
                <a href="{{ url('/') }}" class="logo ml-lg-0">
                    <img src="{{ asset('storage/'.get_settings('logo')) }}" alt="logo" width="144" height="45" />
                </a>
                <form method="get" action="{{ route('category_product') }}"
                      class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                    <div class="select-box">
                        <select id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($app_categories as $app_category)
                            <option {{ old('category') == $app_category->slug ? 'selected' : '' }} value="{{ $app_category->slug }}">{{ $app_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" name="search" value="{{ old('search') }}" id="search" placeholder="Search in..."
                           required />
                    <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                    </button>
                </form>
            </div>
            <div class="header-right ml-4">
                <div class="header-call d-xs-show d-lg-flex align-items-center">
                    <a href="tel:#" class="w-icon-call"></a>
                    <div class="call-info d-lg-show">
                        <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                            <a href="mailto:#" class="text-capitalize">Live Chat</a> or :</h4>
                        <a href="tel:#" class="phone-number font-weight-bolder ls-50">{{ get_settings('phone') }}</a>
                    </div>
                </div>
                <a class="wishlist label-down link d-xs-show" href="{{ route('wishlist.index') }}">
                    <i class="w-icon-heart"></i>
                    <span class="wishlist-label d-lg-show">Wishlist</span>
                </a>
                <a class="wishlist label-down link d-xs-show" href="{{ route('user.dashboard') }}">
                    <i class="w-icon-user"></i>
                    <span class="wishlist-label d-lg-show">Account</span>
                </a>

                <style>
                    .cart-dropdown .cart-toggles {
                        padding: 0;
                    }
                    .cart-dropdown .cart-toggles::after {
                        content: none;
                    }
                </style>
                <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                    <div class="cart-overlay"></div>
                    <a href="{{ route('view_cart') }}" class="{{--cart-toggle--}} cart-toggles label-down link">
                        <i class="w-icon-cart">
                            <span class="cart-count">{{ count(Session::get('cart', [])) }}</span>
                        </i>
                        <span class="cart-label">Cart</span>
                    </a>

                   {{-- @php($carts = Session::get('cart', []))

                    <?php
                    $sub_total = 0;
                    $total_discount = 0;
                    $grant_total = 0;
                    $coupon_discount = session()->has('coupon_code') ? session()->get('coupon_discount') : 0;
                    ?>

                    <div class="dropdown-box">
                        <div class="cart-header">
                            <span>Shopping Cart</span>
                            <a href="javascript:void(0)" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
                        </div>

                        @if(count($carts) > 0)
                            <div class="products">
                                @foreach($carts ?? [] as $cart)

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
                                        <div class="product product-cart">
                                            <div class="product-detail">
                                                <a href="{{ route('product_details', $product->slug) }}" class="product-name">{{ Str::limit($product->name, 40) }}</a>
                                                <div class="price-box">
                                                    <span class="product-quantity">{{ $qty }}</span>
                                                    <span class="product-price">{{ base_currency().$discount_price }}</span>
                                                </div>
                                            </div>
                                            <figure class="product-media">
                                                <a href="{{ route('product_details', $product->slug) }}">
                                                    <img src="{{ asset('storage/'.$product->image) }}" alt="product" height="84"
                                                         width="94" />
                                                </a>
                                            </figure>
                                            --}}{{--<button class="btn btn-link btn-close" aria-label="button">
                                                <i class="fas fa-times"></i>
                                            </button>--}}{{--
                                        </div>
                                    @endif
                                    <?php
                                    $sub_total += ($main_price * $qty) ;
                                    $total_discount += ($discount_amount*$qty);
                                    $grant_total += ($discount_price*$qty);
                                    ?>
                                @endforeach
                            </div>

                            <div class="cart-total mb-3 mt-5" style="padding: 0">
                                <label>Subtotal:</label>
                                <span class="price">{{ base_currency().$sub_total }}</span>
                            </div>

                            <div class="cart-total mb-3" style="padding: 0">
                                <label>Discount Amount:</label>
                                <span class="price">- {{ base_currency().$total_discount }}</span>
                            </div>

                            <div class="cart-total mb-3" style="padding: 0">
                                <label>Coupon Discount:</label>
                                <span class="price">- {{ base_currency().$coupon_discount }}</span>
                            </div>

                            <div class="cart-total mb-6" style="padding: 0">
                                <label>Total:</label>
                                <span class="price">- {{ base_currency().($grant_total-$coupon_discount) }}</span>
                            </div>
                        @else
                            <p style="color: red" class="text-center mt-10 mb-10">Your Cart is empty</p>
                        @endif

                        <div class="cart-action w-100">
                            <a href="{{ route('view_cart') }}" class="btn btn-dark btn-outline btn-rounded d-block w-100">View Cart</a>

                        </div>
                    </div>
                    <!-- End of Dropdown Box -->--}}
                </div>
            </div>
        </div>
    </div>
    <!-- End of Header Middle -->

    <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
        <div class="container">
            <div class="inner-wrap">
                <div class="header-left">
                    <div class="dropdown category-dropdown has-border" data-visible="true">
                        @if(request()->is('/'))
                        <a href="#" class="category-toggle text-dark" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="true" data-display="static"
                           title="Browse Categories">
                            <i class="w-icon-category"></i>
                            <span>Browse Categories</span>
                        </a>
                        @else
                            <a href="#" class="category-toggle" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="true" data-display="static"
                               title="Browse Categories">
                                <i class="w-icon-category"></i>
                                <span>Browse Categories</span>
                            </a>

                        @endif

                        <div class="dropdown-box">
                            <ul class="menu vertical-menu category-menu">
                                @foreach($app_categories as $category)
                                <li>
                                    <a href="{{ route('category_product', ['category' => $category->slug]) }}">
                                        <i class="{{ $category->icon }}"></i>{{ $category->name }}
                                    </a>
                                    @if($category->subcategories != null && $category->subcategories->count() > 0)
                                    <ul>
                                        @foreach($category->subcategories as $subcategory)
                                        <li><a href="{{ route('category_product', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach

                                {{--<li>
                                    <a href="shop-fullwidth-banner.html">
                                        <i class="w-icon-ruby"></i>Accessories
                                    </a>
                                </li>--}}
                                <li>
                                    <a href="{{ route('category_product') }}"
                                       class="font-weight-bold text-primary text-uppercase ls-25">
                                        View All Categories<i class="w-icon-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <nav class="main-nav">
                        <ul class="menu active-underline">
                            <li class="{{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="{{ request()->is('products*') ? 'active' : '' }}">
                                <a href="{{ route('category_product') }}">Shop</a>
                            </li>

                            <li class="{{ request()->is('videos*') ? 'active' : '' }}">
                                <a href="{{ route('videos') }}">Videos</a>
                            </li>

                            <li class="{{ request()->is('contact-us') ? 'active' : '' }}">
                                <a href="{{ route('contact_us') }}">Contact US</a>
                            </li>

                            @if(!\Illuminate\Support\Facades\Auth::check())
                                <li class="{{ request()->is('login') ? 'active' : '' }}">
                                    <a href="{{ route('login') }}">Login</a>
                                </li>

                                <li class="{{ request()->is('register') ? 'active' : '' }}">
                                    <a href="{{ route('register') }}">Register</a>
                                </li>
                            @else
                                <li class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('user.dashboard') }}">My Account</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('user.dashboard') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </li>
                            @endif

                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <a href="{{ route('user.order_list') }}" class="d-xl-show scrollDiv"><i class="w-icon-map-marker mr-1"></i>Track Order</a>
                    <a href="javascript:void(0)" onclick="scrollToDiv()"><i class="w-icon-sale"></i>Daily Deals</a>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Start of Mobile Menu -->
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay"></div>
    <!-- End of .mobile-menu-overlay -->

    <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
    <!-- End of .mobile-menu-close -->

    <div class="mobile-menu-container scrollable">
        <form action="{{ route('category_product') }}" method="get" class="input-wrapper">
            <input type="text" class="form-control" value="{{ old('search') }}" name="search" autocomplete="off" placeholder="Search"
                   required />
            <button class="btn btn-search" type="submit">
                <i class="w-icon-search"></i>
            </button>
        </form>
        <!-- End of Search Form -->
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#main-menu" class="nav-link active">Main Menu</a>
                </li>
                <li class="nav-item">
                    <a href="#categories" class="nav-link">Categories</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="main-menu">
                <ul class="mobile-menu">
                    <li>
                        <a style="color:{{ request()->is('/') ? '#1914fe' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a style="color:{{ request()->is('product*') ? '#1914fe' : '' }} " href="{{ route('category_product') }}">Shop</a>
                    </li>
                    <li class="">
                        <a style="color:{{ request()->is('videos*') ? '#1914fe' : '' }} " href="{{ route('videos') }}">Videos</a>
                    </li>
                    <li class="">
                        <a style="color:{{ request()->is('contact-us') ? '#1914fe' : '' }} " href="{{ route('contact_us') }}">Contact US</a>
                    </li>

                    @if(!\Illuminate\Support\Facades\Auth::check())
                        <li>
                            <a style="color:{{ request()->is('login') ? '#1914fe' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>

                        <li>
                            <a style="color:{{ request()->is('register') ? '#1914fe' : '' }}" href="{{ route('register') }}?refer_code=UPN4YES0">Register</a>
                        </li>
                    @else
                        <li>
                            <a style="color:{{ request()->is('user/dashboard') ? '#1914fe' : '' }}" href="{{ route('user.dashboard') }}">My Account</a>
                        </li>
                        <li class="">
                            <a href="{{ route('user.dashboard') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                    @endif
                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <ul class="mobile-menu">
                    @foreach($app_categories as $category)
                        <li>
                            <a href="{{ route('category_product', ['category' => $category->slug]) }}">
                                <i class="{{ $category->icon }}"></i>{{ $category->name }}
                            </a>
                            @if($category->subcategories != null && $category->subcategories->count() > 0)
                                <ul>
                                    @foreach($category->subcategories as $subcategory)
                                        <li><a href="{{ route('category_product', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                        <li>
                            <a href="{{ route('category_product') }}"
                               class="font-weight-bold text-primary text-uppercase ls-25">
                                View All Categories<i class="w-icon-angle-right"></i>
                            </a>
                        </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End of Mobile Menu -->
