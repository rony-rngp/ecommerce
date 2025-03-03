@extends('layouts.backend.app')

@section('title', 'Create Coupon')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Coupon</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.coupons.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="title">Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required >
                                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="code">
                                        Coupon Code <i class="text-danger">*</i>
                                        <a href="javascript:void(0)" style="float: right" class="text-danger" onclick="generateCode()">Generate code</a>
                                    </label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="{{ \Illuminate\Support\Str::random(8) }}" value="{{ old('code') }}" required >
                                    <span class="text-danger">{{ $errors->has('code') ? $errors->first('code') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="start_date">Start Date <i class="text-danger">*</i></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}" required >
                                    <span class="text-danger">{{ $errors->has('start_date') ? $errors->first('start_date') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="end_date">End Date <i class="text-danger">*</i></label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date') }}" required >
                                    <span class="text-danger">{{ $errors->has('end_date') ? $errors->first('end_date') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="discount">Discount (%) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="discount" id="discount" value="{{ old('discount') }}" required >
                                    <span class="text-danger">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="min_purchase">Minimum Purchase <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="min_purchase" id="min_purchase" value="{{ old('min_purchase') }}" required >
                                    <span class="text-danger">{{ $errors->has('min_purchase') ? $errors->first('min_purchase') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="max_discount">Max Discount <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="max_discount" id="max_discount" value="{{ old('max_discount') }}" required >
                                    <span class="text-danger">{{ $errors->has('max_discount') ? $errors->first('max_discount') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
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
<script>
    function generateCode() {
        var length = 8;
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var result = '';
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        $("#code").val(result);
    }
</script>
@endpush
