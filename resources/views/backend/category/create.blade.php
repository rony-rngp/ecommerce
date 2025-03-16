@extends('layouts.backend.app')

@section('title', 'Create Category')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Category</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required >
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="slug">Slug <i class="text-danger">*</i></label>
                                    <input type="text" style="background-color: #f6f6f6;" readonly class="form-control" name="slug" id="slug" value="{{ old('slug') }}" required >
                                    <span class="text-danger">{{ $errors->has('slug') ? $errors->first('slug') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="icon">Icon  <i class="text-danger">*</i> &nbsp; &nbsp;<a target="_blank" href="https://d-themes.com/wordpress/wolmart/elements/elements/icons-library/">Pick Icon From Here</a></label>
                                    <input type="text" class="form-control" name="icon" id="package" value="{{ old('icon') }}" required >
                                    <span class="text-danger">{{ $errors->has('icon') ? $errors->first('icon') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="image">Image (Width:190px Height:184)<i class="text-danger">*</i></label>
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
        $(document).ready(function() {
            $('#name').on('keyup', function() {
                // Get the value of the title input
                var title = $(this).val();

                // Convert the title to a slug
                var slug = title
                    .toLowerCase() // Convert to lowercase
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
                    .replace(/^-+|-+$/g, ''); // Trim hyphens from the start and end

                // Set the slug input value
                $('#slug').val(slug);
            });
        });
    </script>
@endpush
