@extends('layouts.backend.app')

@section('title', 'Website Settings')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Website Settings</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.website_settings') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="website_name">Website Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="website_name" id="name" value="{{ get_settings('website_name') }}" required >
                                    <span class="text-danger">{{ $errors->has('website_name') ? $errors->first('website_name') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="email">Email <i class="text-danger">*</i></label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ get_settings('email') }}" required >
                                    <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="phone">Phone <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ get_settings('phone') }}" required >
                                    <span class="text-danger">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="address">Address <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="address" id="phone" value="{{ get_settings('address') }}" required >
                                    <span class="text-danger">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="copyright_text">Copyright Text <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="copyright_text" id="copyright_text" value="{{ get_settings('copyright_text') }}" required >
                                    <span class="text-danger">{{ $errors->has('copyright_text') ? $errors->first('copyright_text') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="currency_name">Currency Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="currency_name" id="currency_name" value="{{ get_settings('currency_name') }}" required >
                                    <span class="text-danger">{{ $errors->has('currency_name') ? $errors->first('currency_name') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="currency_symbol">Currency Symbol <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="currency_symbol" id="currency_symbol" value="{{ get_settings('currency_symbol') }}" required >
                                    <span class="text-danger">{{ $errors->has('currency_symbol') ? $errors->first('currency_symbol') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="online_payment_status">Online Payment Status <i class="text-danger">*</i></label>
                                    <select name="online_payment_status" id="online_payment_status" class="form-control">
                                        <option {{ get_settings('online_payment_status') == '1' ? 'selected' : '' }} value="1">Enable</option>
                                        <option {{ get_settings('online_payment_status') == '0' ? 'selected' : '' }} value="0">Disable</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('online_payment_status') ? $errors->first('online_payment_status') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="offline_payment_status">Offline Payment Status <i class="text-danger">*</i></label>
                                    <select name="offline_payment_status" id="offline_payment_status" class="form-control">
                                        <option {{ get_settings('offline_payment_status') == '1' ? 'selected' : '' }} value="1">Enable</option>
                                        <option {{ get_settings('offline_payment_status') == '0' ? 'selected' : '' }} value="0">Disable</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('offline_payment_status') ? $errors->first('offline_payment_status') : '' }}</span>
                                </div>


                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="logo">Logo <i class="text-danger">*</i></label>
                                                <input type="file" class="form-control" accept="image/*"  name="logo" id="logo" >
                                                <span class="text-danger">{{ $errors->has('logo') ? $errors->first('logo') : '' }}</span>
                                            </div>
                                            <div>
                                                <img height="45" width="144" src="{{ asset('storage/'.get_settings('logo'))  }}" alt="">
                                            </div>
                                        </div>


                                        <div class="mb-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="favicon">Favicon <i class="text-danger">*</i></label>
                                                <input type="file" class="form-control" accept="image/*"  name="favicon" id="favicon" >
                                                <span class="text-danger">{{ $errors->has('favicon') ? $errors->first('favicon') : '' }}</span>
                                            </div>
                                            <div>
                                                <img height="32" width="32" src="{{ asset('storage/'.get_settings('favicon'))  }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary validate">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')

@endpush
