@extends('layouts.frontend.app')

@section('title', 'Login')

@push('css')

@endpush

@section('content')

    <main class="main login-page">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Login</h1>
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
        <div class="page-content">
            <div class="container">
                <div class="login-popup">
                    <div class=" tab-nav-boxed tab-nav-center tab-nav-underline">
                        <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link {{ request()->is('login') ? 'active' : '' }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link acti">Sign Up</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="sign-in">
                                <form action="{{ route('login') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>Email <span style="color: red">*</span></label>
                                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" required>
                                        <span style="color: red">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Password <span style="color: red">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password" required>
                                        <span style="color: red">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                                    </div>
                                    <div class="form-checkbox d-flex align-items-center justify-content-between">
                                        <input type="checkbox" class="custom-checkbox" id="remember" name="remember" >
                                        <label for="remember">Remember me</label>
                                        <a href="{{ route('forgot_password') }}">Lost your password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>

                                </form>
                            </div>

                        </div>
                        {{--<p class="text-center">Sign in with social account</p>
                        <div class="social-icons social-icon-border-color d-flex justify-content-center">
                            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                            <a href="#" class="social-icon social-google fab fa-google"></a>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('js')

@endpush
