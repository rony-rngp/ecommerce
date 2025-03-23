@extends('layouts.backend.app')

@section('title', 'Edit Product')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/quill/quill.css') }}">
    <style>
        .ql-snow.ql-toolbar button:hover,.ql-snow.ql-toolbar button:focus,.ql-snow.ql-toolbar button.ql-active,.ql-snow.ql-toolbar .ql-picker-label:hover,.ql-snow.ql-toolbar .ql-picker-label.ql-active,.ql-snow.ql-toolbar .ql-picker-item:hover,.ql-snow.ql-toolbar .ql-picker-item.ql-selected,.ql-snow .ql-toolbar button:hover,.ql-snow .ql-toolbar button:focus,.ql-snow .ql-toolbar button.ql-active,.ql-snow .ql-toolbar .ql-picker-label:hover,.ql-snow .ql-toolbar .ql-picker-label.ql-active,.ql-snow .ql-toolbar .ql-picker-item:hover,.ql-snow .ql-toolbar .ql-picker-item.ql-selected {
            color: #696cff !important
        }
        .ql-snow.ql-toolbar button:hover .ql-fill,.ql-snow.ql-toolbar button:focus .ql-fill,.ql-snow.ql-toolbar button.ql-active .ql-fill,.ql-snow.ql-toolbar .ql-picker-label:hover .ql-fill,.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-fill,.ql-snow.ql-toolbar .ql-picker-item:hover .ql-fill,.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-fill,.ql-snow.ql-toolbar button:hover .ql-stroke.ql-fill,.ql-snow.ql-toolbar button:focus .ql-stroke.ql-fill,.ql-snow.ql-toolbar button.ql-active .ql-stroke.ql-fill,.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill,.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill,.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill,.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill,.ql-snow .ql-toolbar button:hover .ql-fill,.ql-snow .ql-toolbar button:focus .ql-fill,.ql-snow .ql-toolbar button.ql-active .ql-fill,.ql-snow .ql-toolbar .ql-picker-label:hover .ql-fill,.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-fill,.ql-snow .ql-toolbar .ql-picker-item:hover .ql-fill,.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-fill,.ql-snow .ql-toolbar button:hover .ql-stroke.ql-fill,.ql-snow .ql-toolbar button:focus .ql-stroke.ql-fill,.ql-snow .ql-toolbar button.ql-active .ql-stroke.ql-fill,.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill,.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill,.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill,.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill {
            fill: #696cff !important
        }
        .ql-snow.ql-toolbar button:hover .ql-stroke,.ql-snow.ql-toolbar button:focus .ql-stroke,.ql-snow.ql-toolbar button.ql-active .ql-stroke,.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke,.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke,.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke,.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke,.ql-snow.ql-toolbar button:hover .ql-stroke-miter,.ql-snow.ql-toolbar button:focus .ql-stroke-miter,.ql-snow.ql-toolbar button.ql-active .ql-stroke-miter,.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke-miter,.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter,.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke-miter,.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter,.ql-snow .ql-toolbar button:hover .ql-stroke,.ql-snow .ql-toolbar button:focus .ql-stroke,.ql-snow .ql-toolbar button.ql-active .ql-stroke,.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke,.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke,.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke,.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke,.ql-snow .ql-toolbar button:hover .ql-stroke-miter,.ql-snow .ql-toolbar button:focus .ql-stroke-miter,.ql-snow .ql-toolbar button.ql-active .ql-stroke-miter,.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke-miter,.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter,.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke-miter,.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter {
            stroke: #696cff !important
        }
        .posted_by{
            background: #f6f6f6; padding: 10px 25px;border-top: 1px solid #ddd !important;border-bottom: 1px solid #ddd !important;
        }
        .font_16{font-size: 16px}
        .font_bold{font-weight: bold}
        .attachment{
            border: 1px solid; border-radius: 12px
        }
        .attachment i{
            font-size: 70px !important;
        }

        @media (max-width: 768px) {
            .user_info, .head_bar{display: block !important;margin-bottom: 15px;}

        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Edit Product</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin-bottom: 0px !important;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('patch')
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Product Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}" required >
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="slug">Product Slug <i class="text-danger">*</i></label>
                                    <input type="text" style="background-color: #f6f6f6;" readonly class="form-control" name="slug" id="slug" value="{{ $product->slug }}" required >
                                    <span class="text-danger">{{ $errors->has('slug') ? $errors->first('slug') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="category_id">Select Category <i class="text-danger">*</i></label>
                                    <select id="category_id" name="category_id" class="form-select" required>
                                        <option value="">Select One</option>
                                        @foreach($categories as $category)
                                            <option {{ $product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="subcategory_id">Select Subcategory</label>
                                    <select id="subcategory_id" name="subcategory_id" class="form-select">
                                        <option value="">Select One</option>
                                        @foreach($subcategories as $subcategory)
                                        <option {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('subcategory_id') ? $errors->first('subcategory_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="brand_id">Select Brand <i class="text-danger">*</i></label>
                                    <select id="brand_id" name="brand_id" class="form-select" required>
                                        <option value="">Select One</option>
                                        @foreach($brands as $brand)
                                            <option {{ $product->brand_id == $brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('brand_id') ? $errors->first('brand_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="sku">SKU <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="sku" id="sku" value="{{ $product->sku }}" required >
                                    <span class="text-danger">{{ $errors->has('sku') ? $errors->first('sku') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="price">Price <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="price" id="price" value="{{ $product->price }}" required >
                                    <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="price">Discount (%) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="discount" id="discount" value="{{ $product->discount }}" required >
                                    <span class="text-danger">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="short_description">Short Description <i class="text-danger">*</i></label>
                                    <textarea name="short_description" class="form-control" rows="4" required >{{ $product->short_description }}</textarea>
                                    <span class="text-danger">{{ $errors->has('short_description') ? $errors->first('short_description') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="priority">Description <i class="text-danger">*</i></label>
                                    <div id="editor">{!! $product->description !!}</div>
                                    <textarea name="description" required id="hidden-textarea" style="display: none">{{ $product->description }}</textarea>
                                    <span class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                </div>


                                <div class="col-md-12 mb-4 ">
                                    <div class="form-check mt-6">
                                        <input class="form-check-input" type="checkbox" value="1" {{ $product->has_attribute == 1 ? 'checked' : '' }} name="has_attribute" id="has_attribute" >
                                        <label class="form-check-label" for="has_attribute"> Has Attribute </label>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-6 {{ $product->has_attribute == 1 ? 'd-none' : '' }}" id="stock_div">
                                    <label class="form-label" for="stock">Product Stock <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="stock" id="stock" value="{{ $product->stock }}" required >
                                    <span class="text-danger">{{ $errors->has('stock') ? $errors->first('stock') : '' }}</span>
                                </div>

                                <div class="col-md-12 mb-4 {{ $product->has_attribute == 1 ? '' : 'd-none' }} " id="attribute_div">
                                    <div class="card">
                                        <div class="border-bottom">
                                            <h5 class="card-header">Product Attribute</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label" for="attribute_title">Attribute Title <i class="text-danger">*</i></label>
                                                <input type="text" name="attribute_title" class="form-control" id="attribute_title" value="{{ $product->attribute_title }}">
                                            </div>

                                            <div class="row">
                                                @foreach($product->attributes as $attribute)
                                                <div class="col-md-12 mb-4" id="inputFormRow2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="attribute">Attribute <i class="text-danger">*</i></label>
                                                            <input type="text" name="attribute[]" value="{{ $attribute->attribute }}" class="form-control" id="attribute">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" for="price">Price <i class="text-danger">*</i></label>
                                                            <input type="number" step="any" name="att_price[]" value="{{ $attribute->price }}" class="form-control" id="att_price">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" for="stock">Stock <i class="text-danger">*</i></label>
                                                            <input type="number" name="att_stock[]" class="form-control" value="{{ $attribute->stock }}" id="att_stock">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <a style="margin-top: 25px;" id="removeRow2" href="javascript:void(0)" class="btn btn-danger"> Remove</a>
                                                        </div>

                                                    </div>
                                                </div>
                                                @endforeach
                                                <div id="newRow2" style="width: 100%"></div>

                                                <div class="col-md-12">
                                                    <button id="addRow2" type="button" class="btn btn-info rect-btn"><i class="fa fa-plus-square "></i> Add another item</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="color_id">Select Colors</label>
                                    <div>
                                        @foreach($colors as $color)
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input"  @foreach($product->product_colors as $product_color) {{ $product_color->color_name == $color->color_name ? 'checked' : '' }}  @endforeach type="checkbox" name="color_id[]" id="color_id{{ $color->id }}" value="{{ $color->id }}">
                                                <label class="form-check-label" for="color_id{{ $color->id }}" title="{{ $color->color_name }}">
                                                    <span class="color d-block" style="background-color: {{ $color->color_code }}; height: 22px; width: 22px; border-radius: 50%; @if(in_array($color->color_name, ['White', 'Snow', 'Ivory', 'MintCream', 'WhiteSmoke'])) border: 1px solid @endif"></span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="text-danger">{{ $errors->has('color_id') ? $errors->first('color_id') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option {{ $product->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $product->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="image">Image (width:300px height: 338px) </label>
                                    <input type="file" class="form-control" accept="image/*" name="image" id="image" >
                                    <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                    @if($product->image != '' && Storage::disk('public')->exists($product->image))
                                        <a class="mt-2 d-block" target="_blank" href="{{ asset('storage/'.$product->image) }}">Show Image</a>
                                    @endif
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary validate">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')

    <script>

        $("#name").mirrorSlug({ output: "#slug", prefix: "", textTransform: "lowercase", seoURL: true });

        $(document).on('change', '#category_id', function () {

            var category_id = $(this).val();

            $.ajax({
                url : "{{ route('admin.get_subcategories') }}",
                type : 'get',
                data : {category_id:category_id},

                success:function (res) {
                    var html = '<option value="">Select One</option>';
                    $.each(res, function (key, v) {
                        html +='<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('#subcategory_id').html(html);
                }
            });
        });



    </script>

    <script>
        $("#has_attribute").on('click', function () {
            var isChecked = $(this).prop('checked');
            if(isChecked){

                $("#stock_div").addClass('d-none');
                $("#stock").removeAttr('required');

                $("#attribute_div").removeClass('d-none');
                $("#attribute_title").attr('required', true);
                $("#attribute").attr('required', true);
                $("#att_price").attr('required', true);
                $("#att_stock").attr('required', true);

            }else{
                $("#stock_div").removeClass('d-none');
                $("#stock").attr('required', true);

                $("#attribute_div").addClass('d-none');
                $("#attribute_title").removeAttr('required');
                $("#attribute").removeAttr('required');
                $("#att_price").removeAttr('required');
                $("#att_stock").removeAttr('required');
            }
        });


        $("#addRow2").click(function () {

            var html = '';
            html += '<div class="col-md-12" id="inputFormRow2">';
            html += '<div class="bd_stl">';
            html += '<div class="row">';

            html += '<div class="col-md-4 mb-4">';
            html += '<label class="form-label" for="attribute">Attribute <i class="text-danger">*</i></label>';
            html += '<input type="text" name="attribute[]" required class="form-control" >';
            html += '</div>';

            html += '<div class="col-md-3 mb-4">';
            html += '<label class="form-label" for="price">Price <i class="text-danger">*</i></label>';
            html += '<input type="number" step="any" name="att_price[]" required class="form-control">';
            html += '</div>';

            html += '<div class="col-md-3 mb-4">';
            html += '<label class="form-label" for="stock">Stock <i class="text-danger">*</i></label>';
            html += '<input type="number" name="att_stock[]" required class="form-control">';
            html += '</div>';

            html += '<div class="col-md-2 mb-4">';
            html += '<a style="margin-top: 25px;" id="removeRow2" href="javascript:void(0)" class="btn btn-danger"> Remove</a>';
            html += '</div>';

            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#newRow2').append(html);
        });
        // remove row
        $(document).on('click', '#removeRow2', function () {
            $(this).closest('#inputFormRow2').remove();
        });

    </script>

    <!-- Include the Quill library -->
    <script src="{{ asset('backend/assets/quill/quill.js') }}"></script>
    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Sync Quill content with hidden textarea
        quill.on('text-change', function() {
            document.getElementById('hidden-textarea').value = quill.root.innerHTML;
        });

    </script>

@endpush
