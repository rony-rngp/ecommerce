@extends('layouts.frontend.app')

@section('title', 'My Refer')

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
                    <li>My Refer</li>
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
                            <div class="text-center mb-5">
                                <div class="mb-2">
                                    <p class="mb-0 text-dark" style="font-size: 17px; font-weight: bold">Total Refer Earning: {{ $total_refer_earning.' '.base_currency_name() }}</p>
                                    <p class="mb-0 text-dark" style="font-size: 17px; font-weight: bold">Current Refer Earning: {{ auth()->user()->refer_balance.' '.base_currency_name() }}</p>
                                    <p class="mb-0 text-dark" style="font-size: 17px; font-weight: bold"> Main Balance: {{ auth()->user()->balance.' '.base_currency_name() }}</p>
                                    <p class="mb-0 text-dark" style="font-size: 17px; font-weight: bold">Refer Code: {{ Auth::user()->refer_code }}</p>
                                    <p class="mb-0 text-dark" style="font-size: 17px; font-weight: bold">Refer Url: <a target="_blank" href="{{ route('register') }}?refer_code={{ Auth::user()->refer_code }}">Refer Url</a></p>
                                </div>
                                <div>
                                    <a href="{{ route('user.my_refer') }}" class="btn btn-primary btn-sm mb-1">Refer Earning</a>
                                    <a href="{{ route('user.convert_to_main_balance') }}" data-title="Convert to main balance" class="ajax-modal btn btn-primary btn-sm mb-1">Convert to main balance</a>
                                    <a href="{{ route('user.my_refer', 'convert_log') }}" class="btn btn-primary btn-sm mb-1">Convert Log</a>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-1 open-deposit-modal">Withdraw</a>
                                </div>
                            </div>

                            @if($type == '')
                            <div class="icon-box icon-box-side icon-box-light" style="margin-bottom: 10px">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">My Refer List ({{ $users->total() }})</h4>
                                </div>

                            </div>

                            <div class="table-responsive" style="white-space: nowrap !important">
                                <table class="shop-table account-orders-table">
                                    <thead>
                                    <tr>
                                        <th class="text-left">SL</th>
                                        <th>User</th>
                                        <th>Total Order</th>
                                        <th>Total Earning</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($users as $key => $user)
                                        <tr>
                                            <td>&nbsp;{{ $key+1 }}</td>
                                            <td class="text-center">
                                                <span class="d-block">{{ $user->name }}</span>
                                                <span class="d-block">{{ $user->email }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $user->delivered_orders_count }}
                                            </td>
                                            <td class="text-center">
                                                @php($earning = \App\Models\Transaction::where(['tran_type' => 'refer_bonus', 'user_id' => auth()->user()->id, 'main_user' => $user->id])->sum('amount'))
                                                {{ base_currency(). $earning }}
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Refer Not Found. Please refer a user first</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                            @endif


                            @if($type == 'convert_log')
                                <div class="icon-box icon-box-side icon-box-light" style="margin-bottom: 10px">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0">Convert Log ({{ $convert_logs->total() }})</h4>
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
                                        @forelse($convert_logs as $key => $convert_log)
                                            <tr>
                                                <td class="text-center">{{ date('F j, Y', strtotime($convert_log->created_at)) }}</td>
                                                <td class="text-center">
                                                    {{ ucfirst(str_replace('_', ' ', $convert_log->tran_type)) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $convert_log->description }}
                                                </td>
                                                <td class="text-center">{{ $convert_log->amount_type == 'credit' ? '+' : '-' }}{{ $convert_log->amount.' '.base_currency_name() }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Convert log Not Found</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <br>
                                    <div>
                                        {{ $convert_logs->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            @endif

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
