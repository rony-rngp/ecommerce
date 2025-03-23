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
                                    <h5 class="mt-2 mb-2">Delivery Option</h5>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label" for="allow_cod">Allow Cash On Delivery <i class="text-danger">*</i></label>
                                    <select name="allow_cod" id="allow_cod" class="form-control">
                                        <option {{ get_settings('allow_cod') == '1' ? 'selected' : '' }} value="1">Enable</option>
                                        <option {{ get_settings('allow_cod') == '0' ? 'selected' : '' }} value="0">Disable</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('allow_cod') ? $errors->first('allow_cod') : '' }}</span>
                                </div>

                                <div class="col-md-3 mb-4">
                                    <label class="form-label" for="in_dhaka">In Dhaka (Delivery Charge) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="in_dhaka" id="in_dhaka" value="{{ get_settings('in_dhaka') }}" required >
                                    <span class="text-danger">{{ $errors->has('in_dhaka') ? $errors->first('in_dhaka') : '' }}</span>
                                </div>

                                <div class="col-md-3 mb-4">
                                    <label class="form-label" for="in_dhaka">Outside Dhaka (Delivery Charge) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="outside_dhaka" id="outside_dhaka" value="{{ get_settings('outside_dhaka') }}" required >
                                    <span class="text-danger">{{ $errors->has('outside_dhaka') ? $errors->first('outside_dhaka') : '' }}</span>
                                </div>


                                <div class="col-md-12">
                                    <h5 class="mt-2 mb-2">Refer Earning</h5>
                                </div>

                                <div class="col-md-6 mb-6">
                                    <label class="form-label" for="allow_refer_income">Allow Refer Earning <i class="text-danger">*</i></label>
                                    <select name="allow_refer_income" id="allow_refer_income" class="form-control">
                                        <option {{ get_settings('allow_refer_income') == '1' ? 'selected' : '' }} value="1">Enable</option>
                                        <option {{ get_settings('allow_refer_income') == '0' ? 'selected' : '' }} value="0">Disable</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('allow_refer_income') ? $errors->first('allow_refer_income') : '' }}</span>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label" for="refer_income">Refer Income (%) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="refer_income" id="refer_income" value="{{ get_settings('refer_income') }}" required >
                                    <span class="text-danger">{{ $errors->has('refer_income') ? $errors->first('refer_income') : '' }}</span>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label" for="min_convert_amount">Minimum Convert Amount <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="min_convert_amount" id="min_convert_amount" value="{{ get_settings('min_convert_amount') }}" required >
                                    <span class="text-danger">{{ $errors->has('min_convert_amount') ? $errors->first('min_convert_amount') : '' }}</span>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label" for="min_withdraw_amount">Minimum Withdraw Amount <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="min_withdraw_amount" id="min_withdraw_amount" value="{{ get_settings('min_withdraw_amount') }}" required >
                                    <span class="text-danger">{{ $errors->has('min_withdraw_amount') ? $errors->first('min_withdraw_amount') : '' }}</span>
                                </div>


                                <div class="col-md-12">
                                    <h5 class=" mb-2">Log & Favicon</h5>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="logo">Logo (Width:144px Height:45px) <i class="text-danger">*</i></label>
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

                                <div class="col-md-12">
                                    <h5 class="mt-2 mb-2">Social Media</h5>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="facebook">Facebook <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="facebook" id="facebook" value="{{ get_settings('facebook') }}"  >
                                    <span class="text-danger">{{ $errors->has('facebook') ? $errors->first('facebook') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="twitter">Twitter <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="twitter" id="twitter" value="{{ get_settings('twitter') }}"  >
                                    <span class="text-danger">{{ $errors->has('twitter') ? $errors->first('twitter') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="instagram">Instagram <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="instagram" id="instagram" value="{{ get_settings('instagram') }}"  >
                                    <span class="text-danger">{{ $errors->has('instagram') ? $errors->first('instagram') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="youtube">Youtube <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="youtube" id="youtube" value="{{ get_settings('youtube') }}"  >
                                    <span class="text-danger">{{ $errors->has('youtube') ? $errors->first('youtube') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="pinterest">Pinterest <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="pinterest" id="pinterest" value="{{ get_settings('pinterest') }}"  >
                                    <span class="text-danger">{{ $errors->has('pinterest') ? $errors->first('pinterest') : '' }}</span>
                                </div>


                                <div class="col-md-12">
                                    <h5 class="mt-2 mb-2">Seo Setting</h5>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="meta_keywords">Meta Keywords </label>
                                    <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" value="{{ get_settings('meta_keywords') }}"  >
                                    <span class="text-danger">{{ $errors->has('meta_keywords') ? $errors->first('meta_keywords') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="meta_description">Meta Description </label>
                                    <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ get_settings('meta_description') }}</textarea>
                                    <span class="text-danger">{{ $errors->has('meta_description') ? $errors->first('meta_description') : '' }}</span>
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
