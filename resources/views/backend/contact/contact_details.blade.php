@extends('layouts.backend.app')

@section('title', 'Contact Details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center " >
                        <h5 class="card-header">Contact Details</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $contact->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ date('F j, Y', strtotime($contact->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td width="50%">{{ $contact->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $contact->email }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">Message:</th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">{!! nl2br($contact->message) !!}</th>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')

@endpush
