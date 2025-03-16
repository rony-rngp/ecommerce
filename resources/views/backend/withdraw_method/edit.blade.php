@extends('layouts.backend.app')

@section('title', 'Edit Withdraw Method')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Edit Withdraw Method</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.withdraw-methods.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.withdraw-methods.update', $withdraw_method->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Withdraw Method Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="method_name" id="method_name" value="{{ $withdraw_method->method_name }}" required >
                                    <span class="text-danger">{{ $errors->has('method_name') ? $errors->first('method_name') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option {{ $withdraw_method->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $withdraw_method->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                </div>



                                <h5 class="mb-3 mt-2">Required Information From Customer</h5>
                                <hr>


                                <div class="col-md-12">
                                    @foreach($withdraw_method->method_information as $key => $method_information)
                                        <div class="row" id="inputFormRow2">
                                            <div class="mb-4 col-md-5">
                                                <label class="form-label" >Input Filed Name <i class="text-danger">*</i></label>
                                                <input type="text" class="form-control" value="{{ $method_information['input_filed_name'] }}" name="input_filed_name[]" required >
                                            </div>
                                            <div class="mb-4 col-md-5">
                                                <label class="form-label" >Is Required <i class="text-danger">*</i></label>
                                                <select name="input_filed_required[]" class="form-control">
                                                    <option {{ $method_information['input_filed_required'] == 1 ? 'selected' : '' }} value="1">Yes</option>
                                                    <option {{ $method_information['input_filed_required'] == 0 ? 'selected' : '' }} value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-4 col-md-2">
                                                @if($key != 0)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="removeRow2" style="margin-top: 27px;">Remove</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div id="newRow2" class="col-md-12">

                                </div>

                                <div class="col-md-12 mb-4">
                                    <a href="javascript:void(0)" id="addRow2" class="btn btn-sm btn-primary">Add New Row</a>
                                </div>

                            </div>

                            <hr>
                            <div>
                                <button type="submit" class="btn btn-primary validate">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')
    <script>

        $("#addRow2").click(function () {
            var html = '';
            html += '<div class="row" id="inputFormRow2">';
            html += '<div class="col-md-5 mb-4">';
            html += '<label class="form-label" >Input Filed Name <i class="text-danger">*</i></label>';
            html += '<input type="text" class="form-control" name="input_filed_name[]" required >';
            html += '</div>';
            html += '<div class="mb-4 col-md-5">';
            html += '<label class="form-label" >Is Required <i class="text-danger">*</i></label>';
            html += '<select name="input_filed_required[]" class="form-control">';
            html += '<option value="1">Yes</option>';
            html += '<option value="0">No</option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="mb-3 col-lg-2">';
            html += '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="removeRow2" style="margin-top: 27px;">Remove</a>';
            html += '</div>';
            html += '</div>';
            $('#newRow2').append(html);
        });
        // remove row
        $(document).on('click', '#removeRow2', function () {
            $(this).closest('#inputFormRow2').remove();
        });
        // End add remove row

    </script>
@endpush
