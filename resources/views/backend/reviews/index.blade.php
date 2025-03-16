@extends('layouts.backend.app')

@section('title', 'Review List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Review List ({{ $reviews->total() }})</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($reviews as $key => $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ date('F j, Y', strtotime($review->created_at)) }}</td>
                                    <td><a target="_blank" href="{{ route('admin.orders.details', $review->order_id) }}">{{ $review->order_id }}</a></td>
                                    <td>
                                        <a target="_blank" href="{{ route('admin.users.details', $review->user_id) }}">
                                            <span class="d-block">{{ @$review->user->name }}</span>
                                            <span class="d-block">{{ @$review->user->email }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ route('product_details', @$review->product->slug) }}">{{ \Illuminate\Support\Str::limit(@$review->product->name, 30) }}</a>
                                    </td>
                                    <td>
                                        @for($i=0; $i <= $review->rating; $i++)
                                            <i class="bx bxs-star"></i>
                                        @endfor
                                    </td>
                                    <td>{{ $review->status == 0 ? 'Pending' : 'Approved' }}</td>
                                   <td>
                                       <div class="dropdown">
                                           <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                               <i class="bx bx-dots-vertical-rounded"></i>
                                           </button>
                                           <div class="dropdown-menu">
                                               <a class="dropdown-item" href="{{ route('admin.reviews.details', $review->id) }}"><i class="bx bx-detail me-1"></i> Details</a>
                                               <a onclick="return confirm('Are you sure?')" class="dropdown-item" href="{{ route('admin.reviews.destroy', $review->id) }}"><i class="bx bx-trash me-1"></i> Delete</a>

                                           </div>
                                       </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $reviews->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
