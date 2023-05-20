@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <div class="container-xxl bg-white p-0">
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">Find your<br>perfect restaurant</h1>
                        <p class="text-white animated slideInLeft mb-4 pb-2">Every restaurant you didn't know it exists is here. Just try our searcher</p>
                        <form action="{{ route('search_location') }}" method="GET" role="search">
                            <div class="form-group has-search">
                                <span class="fa fa-search form-control-feedback"></span>
                                <input type="text" id="search-location-input" class="form-control ui-autocomplete-input" placeholder="Search where to find your restaurant">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('top-restaurants', ['restaurants_rate' => $restaurants_rate])

    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Featured</h5>
            <h2 class="mb-5">Restaurant of the week</h2>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="blog-card bg-white mb-4 overflow-hidden d-lg-flex rounded-lg position-relative">
                    <div class="blog-image overflow-hidden d-flex align-items-center">
                        <a href="{{ route('restaurant', ['id' => $featured_restaurant->id]) }}">
                        <img src="{{ asset('storage/' . $featured_restaurant->main_image_url) }}" alt="{{ $featured_restaurant->main_image_url }}" class="blog-thumbnail">
                        </a>
                    </div>
                    <div class="p-4 blog-container">
                        <h4 class="mt-2 font-weight-bold">
                            <a href="{{ route('restaurant', ['id' => $featured_restaurant->id]) }}" class="text-dark" title="{{ $featured_restaurant->description }}">{{ $featured_restaurant->name }}</a>
                        </h4>
                        <p class="text-muted">{{ $featured_restaurant->description }}</p>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="container-xxl py-5">
        <div class="text-center wow fadeInUp">
            <h1 class="mb-5">How to find your perfect restaurant?</h1>
        </div>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x text-primary mb-4">1</i>
                            <h5>Create your user</h5>
                            <p>Register your personal data and join us.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x text-primary mb-4">2</i>
                            <h5>Define your preferences</h5>
                            <p>Tell us which are your favorite types of food, time to eat...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x text-primary mb-4">3</i>
                            <h5>Recommendations page</h5>
                            <p>Access to your customized recommendations page.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x text-primary mb-4">4</i>
                            <h5>Go to the restaurant</h5>
                            <p>You'll see our algorithm doesn't lie! Enjoy your new favorite restaurant.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        $('#search-location-input').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{route('search_location')}}",
                    dataType: 'json',
                    data: {
                        query: request.term
                    },
                    success: function(data){
                        response(data)
                    }
                });
            },
            minLength: 3,
            delay: 250
        });

        $('#exampleModalCenter').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus');
        });

    </script>

@endsection


