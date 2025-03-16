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
                    <li>My account</li>
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

                        <div id="account-details">
                            <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-account mr-2">
                                        <i class="w-icon-user"></i>
                                    </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">Account Details</h4>
                                </div>
                            </div>
                            <form class="form account-details-form" action="{{ route('user.update_account_details') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text" id="name" value="{{ $user->name }}" required name="name" class="form-control form-control-md">
                                    <span style="color: red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address *</label>
                                    <input type="email" id="email" readonly value="{{ $user->email }}" class="form-control form-control-md">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone *</label>
                                    <input type="number" id="phone" value="{{ $user->phone }}" required name="phone" class="form-control form-control-md">
                                    <span style="color: red">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
                                </div>
                                <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4 mt-1">Save Changes</button>

                            </form>



                            <h4 class="title title-password ls-25 font-weight-bold">Password change</h4>
                            <form class="form account-details-form" action="{{ route('user.update_password') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="text-dark" for="current_password">Current Password</label>
                                    <input type="password" required class="form-control form-control-md" id="current_password" name="current_password">
                                    <span style="color: red">{{ $errors->has('current_password') ? $errors->first('current_password') : '' }}</span>
                                </div>

                                <div class="form-group">
                                    <label class="text-dark" for="password">New Password</label>
                                    <input type="password" required class="form-control form-control-md" id="password" name="password">
                                    <span style="color: red">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                                </div>

                                <div class="form-group">
                                    <label class="text-dark" for="password_confirmation">Confirm Password</label>
                                    <input type="password" required class="form-control form-control-md" id="password_confirmation" name="password_confirmation">
                                    <span style="color: red">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</span>
                                </div>

                                <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4 mt-1">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->

    </main>

@endsection

@push('js')

@endpush
