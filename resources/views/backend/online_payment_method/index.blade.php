@extends('layouts.backend.app')

@section('title', 'Online Payment Method')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @php($ssl_commerz=get_settings('ssl_commerz'))
            @isset($ssl_commerz)
            <div class="col-md-12">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">SSL COMMERZ</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.online_payment_method_update') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="mode">Mode <i class="text-danger">*</i></label>
                                    <select id="mode" name="mode" class="form-select" required>
                                        <option {{ $ssl_commerz['mode'] == 'live' ? 'selected' : '' }} value="live">Live</option>
                                        <option {{ $ssl_commerz['mode'] == 'test' ? 'selected' : '' }} value="test">Test</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('mode') ? $errors->first('mode') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="gateway_title">Gateway Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="gateway_title" id="gateway_title" value="{{ $ssl_commerz['gateway_title'] }}" required >
                                    <span class="text-danger">{{ $errors->has('gateway_title') ? $errors->first('gateway_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="store_id">Store Id <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="store_id" id="store_id" value="{{ $ssl_commerz['store_id'] }}" required >
                                    <span class="text-danger">{{ $errors->has('store_id') ? $errors->first('store_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="store_password">Store Password <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="store_password" id="store_password" value="{{ $ssl_commerz['store_password'] }}" required >
                                    <span class="text-danger">{{ $errors->has('store_password') ? $errors->first('store_password') : '' }}</span>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary validate">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            @endisset
        </div>

    </div>


@endsection

@push('js')

@endpush
