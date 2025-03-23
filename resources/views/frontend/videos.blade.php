@extends('layouts.frontend.app')

@section('title', 'Our Videos')

@push('css')
    <style>
        .playBtn{ position: absolute; top: 38%; left: 45%; height: 50px; width: 50px; background: #0000007d; border-radius: 50%}
        .playBtn .platIcon{font-size: 20px; top: 15px; right: 15px; position: absolute; color: white}
    </style>
@endpush

@section('content')
    <!-- Start of Main -->
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Our Videos</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav mb-10 pb-1">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Videos</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content contact-us">
            <div class="container">

                <div class="row grid cols-xl-4 cols-lg-3 cols-md-2 mb-2" data-grid-options="{
                        'layoutMode': 'fitRows'
                    }">
                    @foreach($videos as $video)
                        <div class="swiper-slide post text-center overlay-zoom">
                            <figure class="post-media br-sm">
                                <a>
                                    <img src="{{ asset('storage/'.$video->image) }}" alt="Post" width="280"
                                         height="180" style="background-color: #4b6e91;" />
                                    <a  href="{{ $video->youtube_url }}" class="playBtn playVideo">
                                        <i class="fas fa-play platIcon"></i>
                                    </a>
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by {{ $video->post_by }} - {{ date('d.m.Y', strtotime($video->created_at)) }}
                                </div>
                                <h5>{{ $video->title }}</h5>
                                <a href="{{ $video->youtube_url }}" class="btn btn-link btn-dark btn-underline playVideo">Play Video<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(count($videos) == 0)
                <div class="mb-7 text-center">
                    <span style="color: red; font-size: 15px">No video available at this time :( </span>
                </div>
                @endif

                <!-- Start of Pagination -->
                <div class="toolbox toolbox-pagination justify-content-between">
                    <p class="showing-info mb-2 mb-sm-0">
                        Showing
                        <span>{{ $videos->firstItem() }}-{{ $videos->lastItem() }} of {{ $videos->total() }}</span>
                        Videos
                    </p>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($videos->onFirstPage())
                            <li class="prev disabled">
                                <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <i class="w-icon-long-arrow-left"></i> Prev
                                </a>
                            </li>
                        @else
                            <li class="prev">
                                <a href="{{ $videos->previousPageUrl() . '&' . http_build_query(request()->query()) }}" aria-label="Previous">
                                    <i class="w-icon-long-arrow-left"></i> Prev
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($videos->links()->elements[0] ?? [] as $page => $url)
                            <li class="page-item {{ $page == $videos->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url . '&' . http_build_query(request()->query()) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($videos->hasMorePages())
                            <li class="next">
                                <a href="{{ $videos->nextPageUrl() . '&' . http_build_query(request()->query()) }}" aria-label="Next">
                                    Next <i class="w-icon-long-arrow-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="next disabled">
                                <a href="#" aria-label="Next" tabindex="-1" aria-disabled="true">
                                    Next <i class="w-icon-long-arrow-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- End of Pagination -->

            </div>

        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection

@push('js')

@endpush
