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

    @include('top-restaurants', ['restaurants_spa' => $restaurants_spa])

    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Top</h5>
            <h2 class="mb-5">Restaurant of the week</h2>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="blog-card bg-white mb-4 overflow-hidden d-lg-flex rounded-lg position-relative">
                    <div class="blog-image overflow-hidden d-flex align-items-center">
                        <img src="images/food2.jpg" alt="" class="blog-thumbnail">
                    </div>
                    <div class="p-4 blog-container">
                        <a href="#!" class="blog-category text-uppercase py-1 px-2 rounded-lg">
                            <small class="font-weight-bold">Food</small>
                        </a>
                        <h4 class="mt-2 font-weight-bold">
                            <a href="#!" class="text-dark" title="Agriculture is good for both humans and animals">Agriculture is good for both humans and animals</a>
                        </h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt, ullam, reprehenderit? Praesentium doloribus soluta, quia.</p>
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
    </script>

@endsection


