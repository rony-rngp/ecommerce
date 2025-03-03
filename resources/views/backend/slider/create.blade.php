@extends('layouts.backend.app')

@section('title', 'Create Slider')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Slider</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="first_title">First Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="first_title" id="first_title" value="{{ old('first_title') }}" required >
                                    <span class="text-danger">{{ $errors->has('first_title') ? $errors->first('first_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="second_title">Second Title </label>
                                    <input type="text" class="form-control" name="second_title" id="second_title" value="{{ old('second_title') }}" >
                                    <span class="text-danger">{{ $errors->has('second_title') ? $errors->first('second_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="third_title">Third Title </label>
                                    <input type="text" class="form-control" name="third_title" id="third_title" value="{{ old('third_title') }}" >
                                    <span class="text-danger">{{ $errors->has('third_title') ? $errors->first('third_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="type">Type <i class="text-danger">*</i></label>
                                    <select id="type" name="type" class="form-select" required>
                                        <option value="product">Product</option>
                                        <option value="category">Category</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('type') ? $errors->first('type') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6 " id="product_div">
                                    <label class="form-label" for="product_id">Product <i class="text-danger">*</i></label>
                                    <select id="product_id" name="product_id" required class="form-select">
                                        <option value="">Select One</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('product_id') ? $errors->first('product_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6 d-none" id="category_div">
                                    <label class="form-label" for="category_id">Category <i class="text-danger">*</i></label>
                                    <select id="category_id" name="category_id" class="form-select">
                                        <option value="">Select One</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</span>
                                </div>


                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="background_image">Background Image (1903 X 520) <i class="text-danger">*</i></label>
                                    <input type="file" class="form-control" accept="image/*" required name="background_image" id="background_image" >
                                    <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="image">Slider Image (474 X 397) <i class="text-danger">*</i></label>
                                    <input type="file" class="form-control" accept="image/*" required name="image" id="image" >
                                    <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
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
        $("#type").on('change', function () {
            var type = $(this).val();
            if(type == 'product'){
                $("#product_div").removeClass('d-none');
                $("#product_id").attr('required', true);

                $("#category_div").addClass('d-none');
                $("#category_id").removeAttr('required');
            }else{
                $("#category_div").removeClass('d-none');
                $("#category_id").attr('required', true);

                $("#product_div").addClass('d-none');
                $("#product_id").removeAttr('required');
            }
        });
    </script>
@endpush
