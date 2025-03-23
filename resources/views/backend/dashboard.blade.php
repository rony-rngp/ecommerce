@extends('layouts.backend.app')

@section('title', 'Admin Dashboard')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Deposit</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_deposits }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total User Current Balance</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_user_balance }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Referral Income</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_refer_earning }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Convert Referral Balance</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_convert }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Withdraw</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_withdraw }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total User Current Refer Balance</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_user_refer_balance }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets/img/icons/unicons/cc-warning.png') }}" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Delivered Orders</p>
                        <h4 class="card-title text-center">{{ $total_orders }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-center mb-10">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('backend/assets/img/icons/unicons/wallet.png') }}" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1 text-center">Total Order Amount</p>
                        <h4 class="card-title text-center">{{ base_currency().$total_order_amount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-6">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Order Statistics</h5>
                        <div class="me-5">
                            <div class="d-flex" style="gap: 10px">
                                <div style="width: 200px;">
                                    <select class="form-control" id="odr_status">
                                        <option value="Delivered">Delivered</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div style="width: 200px">
                                    <select class="form-control" id="order_static">
                                        <option selected value="this_year">This Year</option>
                                        <option value="this_month">This Month</option>
                                        <option value="this_week">This Week</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="order_static">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Sales Statistics</h5>
                        <div class="me-5">
                            <div class="d-flex" style="gap: 10px">
                                <div style="width: 300px">
                                    <select class="form-control" id="sales_static">
                                        <option selected value="this_year">This Year</option>
                                        <option value="this_month">This Month</option>
                                        <option value="this_week">This Week</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="">
                            <canvas id="sales"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    $(document).ready(function (){

        $("#order_static").on('change', function () {
            var val = $(this).val();
            var order_status = $("#odr_status").val();
            order_static(val, order_status);
        });

        $("#odr_status").on('change', function () {
            var order_status = $(this).val();
            var date_type = $("#order_static").val();
            order_static(date_type, order_status);
        });
        order_static('this_year', 'Delivered');

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart;
        function order_static(date_type, order_status) {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.dashboard.order_static') }}',
                data: {date_type: date_type, status:order_status},
                success: function (response) {
                    data = response;
                    var maxDataValue = Math.max(...data.datasets.flatMap(dataset => dataset.data));
                    var suggestedMax = maxDataValue + 1;

                    if (myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    min: 0, // Set minimum value to zero
                                    suggestedMax: suggestedMax, // Set suggested maximum value
                                }
                            },
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 10,
                                    top: 10,
                                    bottom: 10
                                }
                            },
                            barPercentage: 0.8, // Set gap between bars
                            categoryPercentage: 0.9,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                        },

                    });
                },
                error: function() {
                    console.log(data);
                }
            });
        }

        //for sales static

        $("#sales_static").on('change', function () {
            var val = $(this).val();
            sales_static(val);
        });
        sales_static('this_year');

        var sales = document.getElementById('sales');
        var mySales;
        function sales_static(val) {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.dashboard.sales_static') }}',
                data: {statistics_type: val},
                success: function (response) {
                    data = response;
                    if (mySales) {
                        mySales.destroy();
                    }
                    mySales =  new Chart(sales, {
                        type: 'line',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value, index, ticks) {
                                            return '{{ base_currency() }}' + value;
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.dataset.label || '';

                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += '{{ base_currency() }}' + context.parsed.y.toFixed(2);
                                            }
                                            return label;
                                        }
                                    }
                                },
                                legend: {
                                    position: 'top', // Position the legend at the top
                                    align: 'end',    // Align the legend text to the end (right)
                                    labels: {
                                        boxWidth: 8, // Width of the color box
                                        boxHeight: 8, // Height of the color box

                                        font: {
                                            size: 14, // Font size of the label text
                                        }
                                    }
                                }
                            }
                        }

                    });
                },
                error: function() {
                    console.log(data);
                }
            });
        }

    });
</script>
@endpush
