@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="container-xxl bg-white p-0">
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">Find your<br>perfect restaurant</h1>
                        <p class="text-white animated slideInLeft mb-4 pb-2">Every restaurant you didn't know it exist is here. Just try our searcher</p>
                        <form action="{{ route('search') }}" method="GET" role="search">
                            <div class="input-group">
                                <input type="text" id="restaurant-search" class="form-control ui-autocomplete-input" placeholder="Search restaurants">
                                <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Menu Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Top</h5>
                <h1 class="mb-5">Most Popular Restaurants</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                            <i class="fa fa-hotdog fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Top</small>
                                <h6 class="mt-n1 mb-0">Hot dogs</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                            <i class="fa fa-hamburger fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Top</small>
                                <h6 class="mt-n1 mb-0">Burger</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
                            <i class="fa fa-carrot fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Top</small>
                                <h6 class="mt-n1 mb-0">Vegan</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/hotdog.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Hot Dog Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Hot Dog Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/burger.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Happy Burger</span>
                                        </h5>
                                        <small class="fst-italic">A burger is a flat round mass of minced meat or vegetables, which is fried and often eaten in a bread roll.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant</span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" src="{{asset('img/vegan.jpg')}}" alt="" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>Vegan Restaurant/span>
                                        </h5>
                                        <small class="fst-italic">This is a description for a Vegan Restaurant. You will be able to find more info in the future./small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->

    <!-- Service Start -->
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h1 class="mb-5">How to find your perfect restaurant?</h1>
    </div>
    <div class="container-xxl py-5">
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
    <!-- Service End -->

@endsection


