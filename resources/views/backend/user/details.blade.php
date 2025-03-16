@extends('layouts.backend.app')

@section('title', 'User Details')

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
                        <p class="mb-1 text-center">Current Balance</p>
                        <h4 class="card-title text-center">{{ base_currency().$user->balance }}</h4>
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
                        <p class="mb-1 text-center">Current Referral Balance</p>
                        <h4 class="card-title text-center">{{ base_currency().$user->refer_balance }}</h4>
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
                        <p class="mb-1 text-center">Total Orders</p>
                        <h4 class="card-title text-center">{{ count($user->delivered_orders) }}</h4>
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
                        <h4 class="card-title text-center">{{ base_currency().$user->delivered_orders->sum('grand_total') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">User Details &nbsp; - &nbsp; ( ID: {{ $user->id }} )</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>Register At</th>
                                <td>{{ date('F j, Y', strtotime($user->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Current Balance</th>
                                <td>{{ $user->balance }} {{ base_currency_name() }}</td>
                            </tr>
                            <tr>
                                <th>Current Refer Balance</th>
                                <td>{{ $user->refer_balance }} {{ base_currency_name() }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>{{ $user->status ?? 1 ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Update User Status</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.users.status', $user->id) }}" onsubmit="return confirm('Are you sure?')" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select" required>
                                    <option {{ $user->status == '0' ? 'selected' : '' }} value="0">Inactive</option>
                                    <option {{ $user->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                </select>
                                <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary validate">Update</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 mt-6">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Refer List ({{ $refers->total() }})</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Total Order</th>
                                <th>Total Earning ({{ $user->name }})</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($refers as $key => $refer)
                                <tr>
                                    <td>{{ $refer->id }}</td>
                                    <td>
                                        <span class="d-block">{{ $refer->name }}</span>
                                        <span class="d-block">{{ $refer->email }}</span>
                                    </td>
                                    <td>{{ $refer->delivered_orders_count }}</td>
                                    <td>
                                        @php($earning = \App\Models\Transaction::where(['tran_type' => 'refer_bonus', 'user_id' => $user->id, 'main_user' => $refer->id])->sum('amount'))
                                        {{ base_currency(). $earning }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" target="_blank" href="{{ route('admin.users.details', $refer->id) }}">View User</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Refer not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $refers->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
