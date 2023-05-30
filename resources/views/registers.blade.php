@extends('layouts.app')

@section('title', 'Registration')

@section('content')

    <!-- Header -->
    <div class="container bg-white p-0">
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Registration</h1>
            </div>
        </div>

        <!-- Register Form -->
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                <form method="POST" action="{{ route('registers') }}" id="registerForm" class="login-sign-up-form">
                @csrf
                <!-- Start Step Indicators -->
                    <div class="form-header d-flex mb-4">
                        <span class="stepIndicator">Personal data</span>
                        <span class="stepIndicator">Food preferences (I)</span>
                        <span class="stepIndicator">Food preferences (II)</span>
                        <span class="stepIndicator">Confirm</span>
                    </div>
                    <!-- End Step Indicators -->

                    <!-- Step 1 -->
                    <div class="step">
                        <p class="text-center mb-4">Personal data</p>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" placeholder="First Name" name="first_name">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="first_name">First Name</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                       placeholder="Last Name" name="last_name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       placeholder="Your Email" name="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="email">Your Email</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" placeholder="Your Password" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="password">Your Password</label>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Step 2 -->
                    <div class="step">
                        <div id="food-type-container">
                            <p class="text-center mb-4">Food types</p>
                            <div class="mb-3">
                                @foreach(array_chunk($food_types->toArray(), 4) as $group)
                                    <div class="row">
                                        @foreach($group as $food_type)
                                            <div class="form-check mb-3 col-md-3 @error('food_types') is-invalid @enderror">
                                                <input class="form-check-input" type="checkbox" name="food_types[]"
                                                       value="{{ $food_type['id'] }}" id="{{ $food_type['name'] }}">
                                                <label class="form-check-label text-wrap" for="{{ $food_type['name'] }}">
                                                    {{ $food_type['name'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('food_types')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Step 3 -->
                    <div class="step">
                        <div id="price-range-container">
                            <p class="text-center mb-4">Price range</p>
                            <div class="mb-3">
                                <div class="row">
                                    @foreach($price_ranges as $price_range)
                                        <div class="form-check mb-3 col-md-3 @error('price_ranges') is-invalid @enderror">
                                            <input class="form-check-input" type="checkbox" name="price_ranges[]"
                                                   value="{{ $price_range->id }}" id="{{ $price_range->range }}">
                                            @error('price_ranges')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <label class="form-check-label" for="{{ $price_range->range }}">
                                                {{ $price_range->range }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="schedule-container">
                            <p class="text-center mb-4">Schedule</p>
                            <div class="mb-3">
                                <div class="row">
                                    @foreach($schedules as $schedule)
                                        <div class="form-check mb-3 col-md-3 @error('schedules') is-invalid @enderror">
                                            <input class="form-check-input" type="checkbox" name="schedules[]"
                                                   value="{{ $schedule->id }}" id="{{ $schedule->schedule_type }}">
                                            @error('schedules')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <label class="form-check-label" for="{{ $schedule->schedule_type }}">
                                                {{ $schedule->schedule_type }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <p class="text-center mb-4">Terrace</p>
                        <div class="mb-3">
                            <div class="form-floating @error('terrace') is-invalid @enderror">
                                <select class="form-select" id="terrace" name="terrace">
                                    <option value="1">Yes, I love it</option>
                                    <option value="2">No, please, let me inside</option>
                                </select>
                                <label for="terrace">Do you like to eat in terraces?</label>
                                @error('terrace')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <p class="text-center mb-4">Location</p>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                                       placeholder="Location" name="location">
                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="location">Location</label>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Step 4 -->
                    <div class="step">
                        <p class="text-center mb-4">Confirm</p>
                        <div class="mb-3">
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>

                    <!-- Start Previous / Next Buttons -->
                    <div class="form-footer">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" id="prevBtn" onclick="nextPrev(-1)"
                                    style="display: inline;">Previous
                            </button>
                            <button class="btn btn-primary ms-auto" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                    <!-- End Previous / Next Buttons -->
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#location').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{route('registers.search.location')}}",
                    dataType: 'json',
                    data: {
                        query: request.term
                    },
                    success: function (data) {
                        response(data)
                    }
                });
            },
            minLength: 3,
            delay: 250
        });
    </script>

@endsection
