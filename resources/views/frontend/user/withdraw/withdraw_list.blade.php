@extends('layouts.frontend.app')

@section('title', 'Withdraw List')

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
                    <li>Withdraws</li>
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
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">Withdraws</h4>
                                </div>

                            </div>
                            <div style="float: right">
                                <button type="button" class="btn btn-dark btn-rounded btn-icon-right open-deposit-modal">Add Withdraw</button>
                            </div>

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="d-block mt-4 mb-4" style="color: red">{{$error}}</div>
                                @endforeach
                            @endif

                            <div class="d-block mt-3">
                                <span class="mb-1 mr-3">Total Withdraw Amount : {{ base_currency().$total_withdraw_amount }}</span>
                                <span class="mb-1 mr-3">Pending Withdraw Amount : {{ base_currency().$pending_withdraw_amount }}</span>
                                <span>Current Refer Balance : {{ base_currency(). auth()->user()->refer_balance }}</span>
                            </div>

                            <div class="table-responsive text-nowrap">
                                <table class="shop-table account-orders-table mb-6">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($withdraws as $withdraw)
                                        <tr>
                                            <td class="text-center">#{{ $withdraw->id }}</td>
                                            <td class="text-center">{{ date('F j, Y', strtotime($withdraw->created_at)) }}</td>
                                            <td class="text-center">{{ $withdraw->amount }} {{ base_currency_name() }}</td>
                                            <td class="text-center">{{ $withdraw->withdraw_method }}</td>
                                            <td class="text-center">
                                                @if($withdraw->status == 'Pending')
                                                    <span style="color: #0b0b0b">{{ $withdraw->status }}</span>
                                                @elseif($withdraw->status == 'Completed')
                                                    <span style="color: green">{{ $withdraw->status }}</span>
                                                @else
                                                    <span style="color: red">{{ $withdraw->status }}</span>
                                                @endif
                                            </td>
                                            <td class="order-action">
                                                <a href="{{ route('user.withdraw_details', \Illuminate\Support\Facades\Crypt::encrypt($withdraw->id)) }}" data-title="Withdraw Details" class="ajax-modal btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Withdraw Not Found. Please withdraw first</td>
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
    <!-- The Login Popup -->
    <div class="deposit-modal login-popup mfp-hide" tabindex="-1" style="padding: 30px 30px; max-width: 700px; border-radius: 10px">

        <div class="">
            <h4>Add Withdraw</h4>
            <hr>

            <form action="{{ route('user.withdraw_store') }}" method="post" id="store_deposit">
                @csrf
                <div class="form-group">
                    <label>Amount <span style="color: red">*</span> ( Minimum amount {{ base_currency().get_settings('min_withdraw_amount') }})</label>
                    <input type="number" class="form-control" min="{{ get_settings('min_withdraw_amount') }}" name="amount" id="amount" required>
                </div>

                <h5>Payment Method Payment</h5>

                @foreach($withdraw_methods as $withdraw_method)

                    <div class="form-check form-check-inline">
                        <input required onclick="showData('{{ $withdraw_method->method_name }}', '{{ json_encode($withdraw_method['method_information']) }}')" class="form-check-input payment_method" type="radio" name="payment_method" id="off_{{ $withdraw_method->id }}" value="{{ $withdraw_method->id }}">
                        <label onclick="showData('{{ $withdraw_method->method_name }}', '{{ json_encode($withdraw_method['method_information']) }}')" class="form-check-label" for="off_{{ $withdraw_method->id }}">{{ $withdraw_method->method_name }}</label>
                    </div>
                @endforeach


                <div class="offline_method d-none" >
                    <h5 class="mt-4 mb-2">Required Information for <span class="get_name"></span></h5>

                    <div class="method_inputs">

                    </div>
                </div>

                <button class="btn btn-dark btn-rounded btn-icon-right mt-3" type="submit">Submit</button>
            </form>

        </div>


    </div>

@endsection

@push('js')
    <script>

        function showData(payment_method, method_information){

            $(".offline_method").removeClass('d-none');
            $(".get_name").html(payment_method);

            method_information = JSON.parse(method_information);
            console.log(method_information)
            $(".method_inputs").html('');
            $(".payment_note").html('');
            for (let i=0; i < method_information.length; i++){
                var field = method_information[i];
                var labelText = field.input_filed_name;
                var isRequired = field.input_filed_required ? 'required' : ''; // If required = 1, mark it required

                // Replace multiple spaces with a single space, then replace spaces with underscores, and convert to lowercase
                var name_data = labelText.replace(/\s+/g, ' ').trim(); // Replace multiple spaces with one
                var name = name_data.replace(/\s/g, '_').toLowerCase(); // Replace spaces with underscores and make lowercase

                // Prepare the HTML structure
                var fieldHTML = `
                    <div class="form-group mb-2">
                        <label>${labelText} ${isRequired ? '<span style="color: red">*</span>' : ''}</label>
                        <input type="text" class="form-control" name="${name}" id="${name}" ${isRequired ? 'required' : ''}>
                    </div>
                `;
                // Append the generated form group to the .method_inputs container
                $(".method_inputs").append(fieldHTML);
            }
        }

        document.querySelector('.open-deposit-modal').addEventListener('click', function () {
            Wolmart.popup({
                items: { src: ".deposit-modal" },
                type: "inline",
                tLoading: "",
                mainClass: "mfp-login mfp-fadein-popup",
                callbacks: {
                    beforeClose: function () {
                        // Optional: Store data or perform actions before closing
                    },
                },
            });
        });



    </script>
@endpush
