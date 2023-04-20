@extends('layouts.app')

@section('title', 'Registration')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Registration</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-0">
            <form method="POST" action="{{ route('registers') }}" id="signUpForm">
            @csrf
            <!-- start step indicators -->
                <div class="form-header d-flex mb-4">
                    <span class="stepIndicator">Personal data</span>
                    <span class="stepIndicator">Food preferences (I)</span>
                    <span class="stepIndicator">Food preferences (II)</span>
                    <span class="stepIndicator">Confirm</span>
                </div>
                <!-- end step indicators -->

                <!-- step one -->
                <div class="step">
                    <p class="text-center mb-4">Personal data</p>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name">
                            <label for="first_name">First Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name">
                            <label for="last_name">Last Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" placeholder="Your Email" name="email">
                            <label for="email">Your Email</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="Your Password" name="password">
                            <label for="password">Your Password</label>
                        </div>
                    </div>
                </div>

                <!-- step two -->
                <div class="step">
                    <p class="text-center mb-4">Food types</p>
                    <div class="mb-3">
                        @foreach($food_types as $food_type)
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="food_types[]" value="{{ $food_type->id }}" id="{{ $food_type->name }}">
                                <label class="form-check-label" for="{{ $food_type->name }}">
                                    {{ $food_type->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- step three -->
                <div class="step">
                    <p class="text-center mb-4">Price range</p>
                    <div class="mb-3">
                        @foreach($price_ranges as $price_range)
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="price_ranges[]" value="{{ $price_range->id }}" id="{{ $price_range->range }}">
                                <label class="form-check-label" for="{{ $price_range->range }}">
                                    {{ $price_range->range }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-center mb-4">Schedule</p>
                    <div class="mb-3">
                        @foreach($schedules as $schedule)
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="schedules[]" value="{{ $schedule->id }}" id="{{ $schedule->schedule_type }}">
                                <label class="form-check-label" for="{{ $schedule->schedule_type }}">
                                    {{ $schedule->schedule_type }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-center mb-4">Terrace</p>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="terrace" name="terrace">
                                <option value="1">Yes, I love it</option>
                                <option value="2">No, please, let me inside</option>
                            </select>
                            <label for="terrace">Do you like to eat in terraces?</label>
                        </div>
                    </div>
                    <p class="text-center mb-4">Location</p>
                    <div class="mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="location" placeholder="Location" name="location">
                                <label for="location">Location</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- step four -->
                <div class="step">
                    <p class="text-center mb-4">Confirm</p>
                    <div class="mb-3">
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>


                <!-- start previous / next buttons -->
                <div class="form-footer text-center">
                    <button class="btn btn-primary" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button class="btn btn-primary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
                <!-- end previous / next buttons -->
            </form>
        </div>
    </div>

    <!-- Registration End -->

@endsection
