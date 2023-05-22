@extends('layouts.app')

@section('title', 'Recommendations')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Recommendations</h1>
        </div>
    </div>

    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Top</h5>
            <h2 class="mb-5">Your unknown perfect restaurants</h2>
        </div>
        @php
            $counter = 1;
        @endphp
        @foreach ($filtered_restaurants as $restaurant)
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="blog-card bg-white mb-4 overflow-hidden d-lg-flex rounded-lg position-relative">
                        <div class="blog-image overflow-hidden d-flex align-items-center">
                            <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                <img src="{{ asset('storage/' . $restaurant->main_image_url) }}" alt="{{ $restaurant->main_image_url }}" class="blog-thumbnail">
                            </a>
                        </div>
                        <div class="p-4 blog-container">
                            <h4 class="mt-2 font-weight-bold">
                                <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}" class="text-dark" title="{{ $restaurant->description }}">{{ $restaurant->name }}</a>
                            </h4>
                            <div class="rating-top" style="margin-bottom: 6px">
                            @foreach(range(1,5) as $i)
                                <span class="fa-stack" style="width:1em">
                                    <i class="far fa-star fa-stack-1x"></i>
                                    @if($restaurant->average_rating >0)
                                        @if($restaurant->average_rating >0.5)
                                            <i class="fas fa-star fa-stack-1x"></i>
                                        @else
                                            <i class="fas fa-star-half fa-stack-1x"></i>
                                        @endif
                                    @endif
                                    @php $restaurant->average_rating--; @endphp
                                </span>
                            @endforeach
                            </div>
                            <p class="text-muted">{{ $restaurant->description }}</p>
                            <div class="blog-footer d-flex justify-content-between align-items-center border-top">
                                <div>
                                    {{ $restaurant->address }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $counter++;
            @endphp
        @endforeach
    </div>


@endsection
