@extends('layouts.backend.app')

@section('title', 'Withdraw Details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">Withdraw Details &nbsp; - &nbsp; ( ID: {{ $withdraw->id }} )</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $withdraw->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ date('F j, Y', strtotime($withdraw->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>{{ $withdraw->amount }} {{ base_currency_name() }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ $withdraw->withdraw_method }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">{{ $withdraw->withdraw_method }} Info:</th>
                            </tr>
                            @foreach($withdraw->withdraw_method_information ?? [] as $withdraw_method_information)
                                <tr>
                                    <th style="width: 50%">{{ $withdraw_method_information['key'] }}</th>
                                    <td>{{ $withdraw_method_information['value'] ?? '' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Status</th>
                                <td>{{ $withdraw->status }}</td>
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
                        <form action="{{ route('admin.withdraws.update_status', $withdraw->id) }}" onsubmit="return confirm('Are you sure?')" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select" required>
                                    <option {{ $withdraw->status == 'Pending' ? 'selected' : '' }} value="Pending">Pending</option>
                                    <option {{ $withdraw->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                    <option {{ $withdraw->status == 'Cancelled' ? 'selected' : '' }} value="Cancelled">Cancelled</option>
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
