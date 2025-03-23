@extends('layouts.backend.app')

@section('title', 'Add Video')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Add Video</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.videos.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.videos.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="post_by">Post By <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="post_by" id="post_by" value="{{ old('post_by') }}" required >
                                    <span class="text-danger">{{ $errors->has('post_by') ? $errors->first('post_by') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="title">Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required >
                                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="youtube_url">Youtube Url <i class="text-danger">*</i></label>
                                    <input type="url" class="form-control" name="youtube_url" id="youtube_url" value="{{ old('youtube_url') }}" required >
                                    <span class="text-danger">{{ $errors->has('youtube_url') ? $errors->first('youtube_url') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="image">Image (Width:295px height:190px) <i class="text-danger">*</i></label>
                                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required >
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
