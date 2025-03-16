@extends('layouts.backend.app')

@section('title', 'Category List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Category List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"> Create Category</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>slug</th>
                                <th>Products</th>
                                <th>Show Home</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($categories as $key => $category)
                                <tr>
                                    <td>{{ $categories->firstitem()+$key }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="40" src="{{ $category->image != '' && Storage::disk('public')->exists($category->image) ? asset('storage/'.$category->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->icon }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" data-id="{{ $category->id }}" type="checkbox" id="homePage" {{ $category->show_home_page == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-{{ $category->status == 1 ? 'success' : 'danger' }}">{{ $category->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $category->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="post" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                                <!--End Delete Data-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
<script>
    $(document).on('change', '#homePage', function () {
        var id = $(this).attr('data-id');
        if(this.checked){
            var show_home_page = 1;
        }else{
            var show_home_page = 0;
        }

        $.ajax({
            url: "{{ route('admin.categories.show_home_page') }}",
            type: "get",
            data: {category_id : id, show_home_page : show_home_page},
            success: function (result) {
                console.log(result);
            }
        })
    });
</script>
@endpush
