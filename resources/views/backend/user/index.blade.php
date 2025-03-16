@extends('layouts.backend.app')

@section('title', 'User List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">User List</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total Refer</th>
                                <th>Total Order</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($users as $key => $user)
                                <tr>
                                    <td>{{ $users->firstitem()+$key }}</td>
                                    <td>
                                        <span class="d-block">{{ $user->name }}</span>
                                        <span class="d-block">{{ $user->email }}</span>
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->refers_count }}</td>
                                    <td>{{ $user->delivered_orders_count }}</td>
                                    <td>{{ base_currency().$user->balance}}</td>
                                    <td><span class="badge bg-{{ $user->status == 1 ? 'success' : 'danger' }}">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.users.details', $user->id) }}" class="btn btn-sm btn-primary">Details</a>
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
                            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
