@extends('layouts.backend.app')

@section('title', 'Deposit Details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">Deposit Details &nbsp; - &nbsp; ( ID: {{ $deposit->id }} )</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $deposit->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ date('F j, Y', strtotime($deposit->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>{{ $deposit->amount }} {{ base_currency_name() }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ $deposit->payment_method }} ({{ ucfirst($deposit->payment_type) }})</td>
                            </tr>
                            @if($deposit->payment_type == 'offline')
                                <tr>
                                    <th colspan="2" class="text-center">Offline Payment Info:</th>
                                </tr>
                                @foreach($deposit->offline_payment_info ?? [] as $offline_payment_info)
                                    <tr>
                                        <th>{{ $offline_payment_info['key'] }}</th>
                                        <td>{{ $offline_payment_info['value'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $deposit->transaction_id }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Status</th>
                                <td>{{ $deposit->status }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Update Status</h5>
                    </div>

                    <div class="card-body">
                        <span class="d-block mb-3" style="color: red">
                            You are allowed to update the status only once. Please ensure that the change you make is final.
                        </span>
                        <form action="{{ route('admin.deposits.update_status', $deposit->id) }}" onsubmit="return confirm('Are you sure?')" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select" required>
                                    <option {{ $deposit->status == 'Pending' ? 'selected' : '' }} value="Pending">Pending</option>
                                    <option {{ $deposit->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                    <option {{ $deposit->status == 'Cancelled' ? 'selected' : '' }} value="Cancelled">Cancelled</option>
                                </select>
                                <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary validate">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
