@extends('layouts.backend.app')

@section('title', 'Subscriber List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Subscriber List</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($subscribers as $key => $subscriber)
                                <tr>
                                    <td>{{ $subscribers->firstitem()+$key }}</td>
                                    <td>{{ $subscriber->email }}</td>
                                    <td>
                                        <a onclick="return confirm('Are you sure?')" href="{{ route('admin.subscribers_destroy', $subscriber->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        <a class="btn btn-sm btn-primary" href="mailto:{{$subscriber->email}}?subject=Newsletter%20Subscription">Send Message</a>
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
                            {{ $subscribers->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
