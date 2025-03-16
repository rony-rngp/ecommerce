@extends('layouts.backend.app')

@section('title', 'Transaction List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Transaction List ({{ $transactions->total() }})</h5>
                    </div>

                    <form action="{{ url()->current() }}" method="get">
                        <div class="row p-5">
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Email <i class="text-danger">*</i></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required="">
                            </div>
                            <div class="mb-4 col-md-4">
                                <div class="mt-6">
                                    <button type="submit" class="btn btn-primary ">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($transactions as $key => $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.users.details', $transaction->user_id) }}">
                                            <span class="d-block">{{ @$transaction->user->name }}</span>
                                            <span class="d-block">{{ @$transaction->user->email }}</span>
                                        </a>
                                    </td>
                                    <td >{{ date('F j, Y', strtotime($transaction->created_at)) }}</td>
                                    <td >
                                        {{ ucfirst(str_replace('_', ' ', $transaction->tran_type)) }}
                                    </td>
                                    <td >
                                        {{ $transaction->description }}
                                    </td>
                                    <td >{{ $transaction->amount_type == 'credit' ? '+' : '-' }}{{ $transaction->amount.' '.base_currency_name() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" >Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
