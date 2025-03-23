@extends('layouts.frontend.app')

@section('title', 'Wishlist')

@push('css')

@endpush

@section('content')

    <!-- Start of Main -->
    <main class="main wishlist-page">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Wishlist</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav mb-10">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Wishlist</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                <h3 class="wishlist-title">My wishlist</h3>
                <table class="shop-table wishlist-table">
                    <thead>
                    <tr>
                        <th class="product-name"><span>Product</span></th>
                        <th></th>
                        <th class="product-price"><span>Price</span></th>
                        <th class="product-stock-status"><span>Stock Status</span></th>
                        <th class="wishlist-action">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($wishlists as $wishlist)
                    <tr>
                        <td class="product-thumbnail">
                            <div class="p-relative">
                                <a href="{{ route('product_details', @$wishlist->product->slug) }}">
                                    <figure>
                                        <img src="{{ asset('storage/'.@$wishlist->product->image) }}" alt="product" width="300"
                                             height="338">
                                    </figure>
                                </a>
                                <button onclick="if (confirm('Are you sure?')) { window.location.href = '{{ route('wishlist.remove', Crypt::encrypt($wishlist->id)) }}'; }" type="button" class="btn btn-close"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </td>
                        <td class="product-name">
                            <a href="{{ route('product_details', @$wishlist->product->slug) }}">
                                {{ @$wishlist->product->name }}
                            </a>
                        </td>
                        <td class="product-price text-center">
                            @if(@$wishlist->product->discount > 0)
                                <ins class="new-price">{{ base_currency(). round(@$wishlist->product->price - ((@$wishlist->product->discount/100)*@$wishlist->product->price )) }}</ins>
                            @else
                                <ins class="new-price">{{ base_currency().@$wishlist->product->price }}</ins>
                            @endif
                        </td>
                        <td class="product-stock-status text-center">
                            <span class="wishlist-in-stock">
                                @if(@$wishlist->product->has_attribute == 1)
                                    {{  @$wishlist->product->attributes->sum('stock') > 0 ?  'In Stock' : 'Out Of Stock' }}
                                @else
                                    {{ @$wishlist->product->stock > 0 ? 'In Stock' : 'Out Of Stock' }}
                                @endif
                            </span>
                        </td>
                        <td class="wishlist-action">
                            <div class="d-lg-flex">
                                <a href="{{ route('quick_view', @$wishlist->product->slug) }}"
                                   class="btn quick_view btn-outline btn-default btn-rounded btn-sm mb-2 mb-lg-0">Quick
                                    View</a>
                                <a href="{{ route('product_details', @$wishlist->product->slug) }}" class="btn btn-dark btn-rounded btn-sm ml-lg-2 btn-cart">Add to
                                    cart</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="mt-4 mb-4">
                                    <span style="color: red; font-size: 15px">No Product In Wishlist</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="social-links">
                    <label>Share On:</label>
                    <div class="social-icons social-no-color border-thin">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-icon social-facebook w-icon-facebook"></a>
                        <a target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode('Check this out!') }}" class="social-icon social-twitter w-icon-twitter"></a>

                        <a target="_blank" href="https://api.whatsapp.com/send?text={{ urlencode('Check this out! ') . urlencode(url()->current()) }}" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}"
                           class="social-icon social-youtube fab fa-linkedin-in"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->

@endsection

@push('js')

@endpush
