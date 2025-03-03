@extends('layouts.frontend.app')

@section('title', 'Register')

@push('css')

@endpush

@section('content')

    <main class="main login-page">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Register</h1>
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
                                <a href="{{ route('login') }}" class="nav-link ">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link active">Sign Up</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                             <div class="tab-pane active" id="sign-up">
                                 <form action="{{ route('register') }}" method="post">
                                     @csrf

                                     <div class="form-group">
                                         <label>Your Name <span style="color: red">*</span></label>
                                         <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" required>
                                         <span style="color: red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                     </div>

                                     <div class="form-group">
                                         <label>Email <span style="color: red">*</span></label>
                                         <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" required>
                                         <span style="color: red">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                     </div>

                                     <div class="form-group">
                                         <label>Phone <span style="color: red">*</span></label>
                                         <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" id="phone" required>
                                         <span style="color: red">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
                                     </div>

                                     <div class="form-group">
                                         <label>Refer Code (Optional)</label>
                                         <input type="text" class="form-control" {{ request()->refer_code != '' ? 'readonly' : '' }} name="refer_code" value="{{ request()->refer_code }}" id="refer">
                                         <span style="color: red">{{ $errors->has('refer_code') ? $errors->first('refer_code') : '' }}</span>
                                     </div>

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


                                     <button type="submit" class="btn btn-primary w-100">Sign Up</button>

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
