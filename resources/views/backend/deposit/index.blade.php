@extends('layouts.backend.app')

@section('title', 'Deposit List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Deposit List ({{ $deposits->total() }})</h5>

                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($deposits as $key => $deposit)
                                <tr>
                                    <td style="color: {{ $deposit->status == 'Pending' ? 'red' : '' }}">#{{ $deposit->id }}</td>
                                    <td>
                                        @if($deposit->user != null)
                                            <span class="d-block">{{ @$deposit->user->name }}</span>
                                            <span class="d-block">{{ @$deposit->user->email }}</span>
                                        @else
                                            <span>User Deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ date('F j, Y', strtotime($deposit->created_at)) }}</td>
                                    <td style="color: {{ $deposit->status == 'Pending' ? 'red' : '' }}">{{ $deposit->amount }} {{ base_currency_name() }}</td>
                                    <td>{{ $deposit->payment_method }} ({{ ucfirst($deposit->payment_type) }})</td>
                                    <td>
                                        @if($deposit->status == 'Pending')
                                            <span class="badge bg-dark" >{{ $deposit->status }}</span>
                                        @elseif($deposit->status == 'Completed')
                                            <span class="badge bg-success">{{ $deposit->status }}</span>
                                        @else
                                            <span class="badge bg-danger" >{{ $deposit->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.deposits.details', $deposit->id) }}" class="btn btn-sm btn-primary">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $deposits->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
