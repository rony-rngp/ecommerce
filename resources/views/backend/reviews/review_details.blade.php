@extends('layouts.backend.app')

@section('title', 'Review Details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">Review Details &nbsp; - &nbsp; ( ID: {{ $review->id }} )</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $review->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ date('F j, Y', strtotime($review->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Order ID</th>
                                <td><a target="_blank" href="{{ route('admin.orders.details', $review->order_id) }}">{{ $review->order_id }}</a></td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>
                                    <a target="_blank" href="{{ route('admin.users.details', $review->user_id) }}">
                                        <span >{{ @$review->user->name }}</span> -
                                        (<span>{{ @$review->user->email }}</span>)
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Product</th>
                                <td>
                                    <a target="_blank" href="{{ route('product_details', @$review->product->slug) }}">{{ @$review->product->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Rating</td>
                                <td>
                                    @for($i=0; $i <= $review->rating; $i++)
                                        <i class="bx bxs-star"></i>
                                    @endfor
                                </td>
                            </tr>
                            <tr>
                                <td>Review</td>
                                <td>
                                   {!! nl2br($review->review) !!}
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $review->status == 0 ? 'Pending' : 'Approved' }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Update Status</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.reviews.status', $review->id) }}"  method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                <select id="status" name="status" class="form-select" required>
                                    <option {{ $review->status == '0' ? 'selected' : '' }} value="0">Pending</option>
                                    <option {{ $review->status == '1' ? 'selected' : '' }} value="1">Approved</option>
                                </select>
                                <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
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

@endpush
