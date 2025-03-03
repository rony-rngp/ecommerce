@extends('layouts.backend.app')

@section('title', 'Create Attribute')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Attribute</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.attributes.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.attributes.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required >
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
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