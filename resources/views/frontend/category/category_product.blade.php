@extends('layouts.frontend.app')

@section('title', 'Home')

@push('css')

@endpush

@section('content')
    <main class="main">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb bb-no">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="javascript:void(0)">Shop</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content mb-10">
            <div class="container">

                <p></p>

                <div class="shop-content toolbox-horizontal">
                    <!-- Start of Toolbox -->
                    <nav class="toolbox sticky-toolbox sticky-content fix-top">
                        <form action="{{ url()->current() }}" method="get">
                            <input type="hidden" name="search" value="{{ old('search') }}">
                            <div class="toolbox-left mr-2">
                                <div class="toolbox-item toolbox-sort select-menu mr-2">
                                    <select name="category" class="form-control">
                                        <option value="" selected="selected">All Categories</option>
                                        @foreach(\App\Models\Category::where('status', 1)->get() as $cat)
                                            <option {{ old('category') == $cat->slug ? 'selected' : '' }} value="{{ $cat->slug }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($category != null && count($category->active_subcategories) > 0)
                                    <div class="toolbox-item toolbox-sort select-menu mr-2">
                                        <select name="subcategory" class="form-control">
                                            <option value="" selected="selected">All Subcategories</option>
                                            @foreach($category->active_subcategories as $sb_cat)
                                                <option {{ old('subcategory') == $sb_cat->slug ? 'selected' : '' }} value="{{ $sb_cat->slug }}">{{ $sb_cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="toolbox-item toolbox-sort select-menu mr-2">
                                    <select name="sort" class="form-control">
                                        <option value="" selected="selected">Default sorting</option>
                                        <option {{ old('sort') == 'price-low' ? 'selected' : '' }} value="price-low">Sort by price: low to high</option>
                                        <option {{ old('sort') == 'price-high' ? 'selected' : '' }} value="price-high">Sort by price: high to low</option>
                                    </select>
                                </div>
                                <div class="toolbox-item toolbox-show select-box mr-2">
                                    <select name="count" class="form-control">
                                        <option {{ old('count') == 12 ? 'selected' : '' }} value="12">Show 12</option>
                                        <option {{ old('count') == 24 ? 'selected' : '' }} value="24">Show 24</option>
                                        <option {{ old('count') == 36 ? 'selected' : '' }} value="36">Show 36</option>
                                    </select>
                                </div>
                                <div class="toolbox-item toolbox-sort">
                                    <button type="submit" class="btn btn-sm btn-primary mr-2">Apply</button>

                                    <a href="{{ url()->current() }}" class="btn btn-sm btn-warning">Clear</a>
                                </div>

                            </div>
                        </form>

                    </nav>
                    <!-- End of Toolbox -->


                    <!-- Start of Product Wrapper -->
                    <div class="product-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-2">
                        @foreach($products as $product)
                        <div class="product-wrap">
                            <div class="product text-center">
                                <figure class="product-media">
                                    <a href="{{ route('product_details', $product->slug) }}">
                                        <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}" alt="Product" width="300"
                                             height="338" />
                                    </a>
                                    <div class="product-action-horizontal">
                                        <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                           title="Quick View"></a>
                                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                           title="Wishlist"></a>
                                        <a href="{{ route('product_details', $product->slug) }}" class="btn-product-icon btn-cart w-icon-cart"
                                           title="Add to cart"></a>

                                    </div>
                                    @if($product->discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                        </div>
                                    @endif
                                </figure>
                                <div class="product-details">
                                    <div class="product-cat">
                                        <a href="{{ route('category_product', ['category' => @$product->category->slug]) }}">{{ @$product->category->name }}</a>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="{{ route('product_details', $product->slug) }}" class="rating-reviews">({{ $product['rating'][0]['rating_count'] ?? 0 }} reviews)</a>
                                    </div>
                                    <div class="product-pa-wrapper">
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
                        </div>
                        @endforeach

                    </div>
                    @if(count($products) == 0)
                        <div class="container text-center  mt-10 mb-10">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Products Found" class="img-fluid" style="max-width: 100px;">

                            <h3 class="mt-4 text-muted">No Products Found</h3>
                            <p class="text-secondary">Sorry, we couldn't find any products matching your search.</p>

                        </div>
                    @endif
                    <!-- End of Product Wrapper -->

                    <!-- Start of Pagination -->
                    <div class="toolbox toolbox-pagination justify-content-between">
                        <p class="showing-info mb-2 mb-sm-0">
                            Showing
                            <span>{{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}</span>
                            Products
                        </p>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="prev disabled">
                                    <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                        <i class="w-icon-long-arrow-left"></i> Prev
                                    </a>
                                </li>
                            @else
                                <li class="prev">
                                    <a href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->query()) }}" aria-label="Previous">
                                        <i class="w-icon-long-arrow-left"></i> Prev
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($products->links()->elements[0] ?? [] as $page => $url)
                                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url . '&' . http_build_query(request()->query()) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <li class="next">
                                    <a href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->query()) }}" aria-label="Next">
                                        Next <i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="next disabled">
                                    <a href="#" aria-label="Next" tabindex="-1" aria-disabled="true">
                                        Next <i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- End of Pagination -->
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
    </main>

@endsection

@push('js')

@endpush
