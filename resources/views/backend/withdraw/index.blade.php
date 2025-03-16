@extends('layouts.backend.app')

@section('title', 'Withdraw List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Withdraw List ({{ $withdraws->total() }})</h5>

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
                            @forelse($withdraws as $key => $withdraw)
                                <tr>
                                    <td style="color: {{ $withdraw->status == 'Pending' ? 'red' : '' }}">#{{ $withdraw->id }}</td>
                                    <td>
                                        @if($withdraw->user != null)
                                            <span class="d-block">{{ @$withdraw->user->name }}</span>
                                            <span class="d-block">{{ @$withdraw->user->email }}</span>
                                        @else
                                            <span>User Deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ date('F j, Y', strtotime($withdraw->created_at)) }}</td>
                                    <td style="color: {{ $withdraw->status == 'Pending' ? 'red' : '' }}">{{ $withdraw->amount }} {{ base_currency_name() }}</td>
                                    <td>{{ $withdraw->withdraw_method }}</td>
                                    <td>
                                        @if($withdraw->status == 'Pending')
                                            <span class="badge bg-dark" >{{ $withdraw->status }}</span>
                                        @elseif($withdraw->status == 'Completed')
                                            <span class="badge bg-success">{{ $withdraw->status }}</span>
                                        @else
                                            <span class="badge bg-danger" >{{ $withdraw->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.withdraws.details', $withdraw->id) }}" class="btn btn-sm btn-primary">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $withdraws->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
