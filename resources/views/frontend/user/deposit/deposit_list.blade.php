@extends('layouts.frontend.app')

@section('title', 'Dashboard')

@push('css')

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
                    <li>Deposits</li>
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
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">Deposits</h4>
                                </div>

                            </div>
                            <div style="float: right">
                                <a href="" class="btn btn-dark btn-rounded btn-icon-right">Add Deposit</a>
                            </div>

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
                                @forelse($deposits as $deposit)
                                <tr>
                                    <td class="text-center">#2318</td>
                                    <td class="text-center">August 20, 2021</td>
                                    <td class="text-center">100 BDT</td>
                                    <td class="text-center">Bkash (Offline)</td>
                                    <td class="text-center">Processing</td>
                                    <td class="order-action">
                                        <a href="#"
                                           class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                    </td>
                                </tr>
                                </tbody>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Deposit Not Found. Please dipost first</td>
                                    </tr>
                                @endforelse
                            </table>



                            <button class="open-login-popup">Login</button>

                            <!-- The Login Popup -->
                            <div class="ajax-modal login-popup mfp-hide" tabindex="-1" style="padding: 30px 30px; max-width: 700px; border-radius: 10px">

                                <div class="">
                                    <h4>Add Deposit</h4>
                                    <hr>

                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Amount <span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="amount" id="amount" required>
                                        </div>

                                        <h5>Payment Method Payment</h5>
                                        @php($online_payment_status = get_settings('online_payment_status'))

                                        @if($online_payment_status == 1)
                                            <div class="form-check form-check-inline">
                                                <input required onclick="showData('ssl_commerz', '', '')" class="form-check-input payment_method" type="radio" name="payment_method" id="ssl_commerz" value="SSLCOMMEZ">
                                                <label onclick="showData('ssl_commerz', '', '')" class="form-check-label" for="ssl_commerz">SSL COMMERZ</label>
                                            </div>
                                        @endif

                                        @php($offline_payment_status = get_settings('offline_payment_status'))
                                        @if($offline_payment_status == 1)
                                            @foreach($offline_payment_methods as $offline_payment_method)
                                                <div class="form-check form-check-inline">
                                                    <input required onclick="showData('{{ $offline_payment_method->method_name }}','{{ json_encode($offline_payment_method['method_fields']) }}', '{{ json_encode($offline_payment_method['method_information']) }}')" class="form-check-input payment_method" type="radio" name="payment_method" id="off_{{ $offline_payment_method->id }}" value="{{ $offline_payment_method->method_name }}">
                                                    <label onclick="showData('{{ $offline_payment_method->method_name }}','{{ json_encode($offline_payment_method['method_fields']) }}', '{{ json_encode($offline_payment_method['method_information']) }}')" class="form-check-label" for="off_{{ $offline_payment_method->id }}">{{ $offline_payment_method->method_name }}</label>
                                                </div>
                                            @endforeach
                                        @endif


                                        <div class="offline_method d-none" >
                                            <h5 class="mt-4 mb-2">Required Information for <span class="get_name">Bkash</span></h5>
                                            <div class="method_filed">

                                            </div>

                                            <div class="method_inputs">

                                            </div>
                                        </div>

                                        <button type="submit">Submit</button>
                                    </form>

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
<script>

    function showData(payment_method, method_fields, method_information){
        if(payment_method != 'ssl_commerz'){

            $(".offline_method").removeClass('d-none');
            $(".get_name").html(payment_method);

            method_fields = JSON.parse(method_fields);
            $(".method_filed").html('');
            for (let x=0; x < method_fields.length; x++){
                $(".method_filed").append('<p class="mb-1">'+method_fields[x].field_name+': '+method_fields[x].field_data+'</p>');
            }

            method_information = JSON.parse(method_information);
            $(".method_inputs").html('');
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

        }else{
            $(".offline_method").addClass('d-none');
            $(".method_filed").html('');
            $(".method_inputs").html('');
        }
    }

    document.querySelector('.open-login-popup').addEventListener('click', function () {
        Wolmart.popup({
            items: { src: ".ajax-modal" },
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
