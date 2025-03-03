@extends('layouts.backend.app')

@section('title', 'Slider List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Slider List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"> Create Slider</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Bg Image</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($sliders as $key => $slider)
                                <tr>
                                    <td>{{ $sliders->firstitem()+$key }}</td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="80" src="{{ $slider->background_image != '' && Storage::disk('public')->exists($slider->background_image) ? asset('storage/'.$slider->background_image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>
                                        <img class=" object-fit-cover" height="40" width="40" src="{{ $slider->image != '' && Storage::disk('public')->exists($slider->image) ? asset('storage/'.$slider->image) : asset('backend/no_image.png') }}" alt="">
                                    </td>
                                    <td>
                                        <span class="d-block">1. {{ $slider->first_title }}</span>
                                        @if($slider->second_title != '')
                                        <span class="d-block">2. {{ $slider->second_title }}</span>
                                        @endif
                                        @if($slider->third_title != '')
                                        <span class="d-block">3. {{ $slider->third_title }}</span>
                                        @endif
                                    </td>
                                    <td >
                                        <span class="d-block" style="text-transform: capitalize">{{ $slider->type }}</span>
                                        @if($slider->type == 'product')
                                        <span style="text-transform: capitalize">{{ @Str::limit($slider->product->name, 30) }}</span>
                                        @else
                                        <span style="text-transform: capitalize">{{ @Str::limit($slider->category->name, 30) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.sliders.edit', $slider->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $slider->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $slider->id }}" action="{{ route('admin.sliders.destroy', $slider->id) }}" method="post" class="d-none">
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
                            {{ $sliders->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
