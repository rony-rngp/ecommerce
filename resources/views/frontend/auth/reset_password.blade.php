@extends('layouts.frontend.app')

@section('title', 'Reset Password')

@push('css')

@endpush

@section('content')

    <main class="main login-page">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Reset Password</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Reset Password</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->
        <div class="page-content">
            <div class="container">
                <div class="login-popup">
                    <h5 class="text-danger m-0 text-center" style="color: red">Enter your new password</h5>

                    @if (\Session::has('success'))
                        <div class="alert alert-danger " role="alert" style="background: #D4EDDA; border: 0; color: #155724">
                            {!! \Session::get('success') !!}
                        </div>
                    @endif

                    <div class="tab-pane active pt-0 mt-5" id="sign-in">
                        <form action="{{ route('reset_password', \Illuminate\Support\Facades\Crypt::encrypt($otp)) }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>Password <span style="color: red">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" required>
                                <span style="color: red">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password <span style="color: red">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                <span style="color: red">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('js')

@endpush
