@extends('layouts.backend.app')

@section('title', 'Create Promotional Category')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Promotional Category</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.promotional-categories.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.promotional-categories.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="title">Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required >
                                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="subtitle">Sub Title </label>
                                    <textarea  class="form-control" rows="3" required name="subtitle" id="subtitle" >{{ old('subtitle') }}</textarea>
                                    <span class="text-danger">{{ $errors->has('subtitle') ? $errors->first('subtitle') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6 ">
                                    <label class="form-label" for="category_id">Category <i class="text-danger">*</i></label>
                                    <select id="category_id" name="category_id" required class="form-select">
                                        <option value="">Select One</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</span>
                                </div>



                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="image">Background Image (610 X 200) <i class="text-danger">*</i></label>
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

@endpush
