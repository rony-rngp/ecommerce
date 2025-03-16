@extends('layouts.frontend.app')

@section('title', 'Transactions')

@push('css')
    <style>
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive > .table {
            margin-bottom: 0;
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
                    <li>Orders</li>
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
                            <div class="icon-box icon-box-side icon-box-light" style="margin-bottom: 10px">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">Transactions ({{ $transactions->total() }})</h4>
                                </div>

                            </div>


                            <div class="table-responsive" style="white-space: nowrap !important">
                                <table class="shop-table account-orders-table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        {{--<th>Payment Status</th>--}}
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td class="text-center">{{ date('F j, Y', strtotime($transaction->created_at)) }}</td>
                                            <td class="text-center">
                                               {{ ucfirst(str_replace('_', ' ', $transaction->tran_type)) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $transaction->description }}
                                            </td>
                                            <td class="text-center">{{ $transaction->amount_type == 'credit' ? '+' : '-' }}{{ $transaction->amount.' '.base_currency_name() }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Deposit Not Found. Please deposit first</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- End of PageContent -->
            <main>

@endsection

@push('js')

@endpush
