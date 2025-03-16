@extends('layouts.frontend.app')

@section('title', $page->page_name)

@push('css')

@endpush

@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">{{ $page->page_name }}</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav pb-8">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>{{ $page->page_name }}</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">
            <section class="introduce mb-10 pb-10">
                {!! $page->content !!}
            </section>
        </div>
    </main>
@endsection

@push('js')

@endpush
