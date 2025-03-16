@extends('layouts.frontend.app')

@section('title', 'My Reviews')

@push('css')
    <style>
        .form-control{border-color: #443636 !important;}
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive > .table {
            margin-bottom: 0;
        }

        .text-nowrap{
            white-space: nowrap !important
        }
    </style>

@endpush

@section('content')

    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">My Account</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Reviews</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content pt-2">
            <div class="container">
                <div class=" tab-vertical row gutter-lg">

                    @include('frontend.user.user_sidebar')

                    <div class="tab-content mb-6">
                        <div>
                            <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-money"></i>
                                    </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">My Reviews</h4>
                                </div>

                            </div>

                            <div class="table-responsive text-nowrap">
                                <table class="shop-table account-orders-table mb-6">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Product</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($reviews as $review)
                                        <tr>
                                            <td class="text-center">{{ date('F j, Y', strtotime($review->created_at)) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.order_details', \Illuminate\Support\Facades\Crypt::encrypt($review->order_id)) }}">{{ $review->order_id }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a target="_blank" href="{{ route('product_details', @$review->product->slug) }}">{{ @$review->product->name }}</a>
                                            </td>
                                            <td class="text-center" style="width: 30%">
                                                @for($i=0; $i <= $review->rating; $i++)
                                                <i class="w-icon-star-full mr-1"></i>
                                                @endfor
                                            </td>
                                            <td class="text-center">{{ $review->status == 1 ? 'Approve' : 'Pending' }}</td>
                                            <td class="order-action">
                                                <a href="{{ route('user.review_details', Crypt::encrypt($review->id)) }}" data-title="Review Details" class="ajax-modal btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Review Not Found. </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End of PageContent -->
    </main>

@endsection

@push('js')

@endpush
