@extends('layouts.app')

@section('title', 'Food Preferences')

@section('content')
    <div class="container bg-white p-0">
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Food preferences</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-0">
            <form method="POST" action="{{ route('user_preferences.update') }}" id="signUpForm" class="login-sign-up-form">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="location" class="col-md-4 col-form-label text-md-end">Location:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location" value="{{ $location }}">
                        @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="terrace" class="col-md-4 col-form-label text-md-end @error('terrace') is-invalid @enderror">Terrace:</label>
                    <div class="col-md-6">
                        <select class="form-select" id="terrace" name="terrace">
                            <option value="1" {{ $terrace ? 'selected' : '' }}>Yes, I love it</option>
                            <option value="0" {{ !$terrace ? 'selected' : '' }}>No, please, let me inside</option>
                        </select>
                    </div>
                    @error('terrace')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="schedules" class="col-md-4 col-form-label text-md-end @error('schedules') is-invalid @enderror">Schedules:</label>
                    <div class="col-md-6">
                        @foreach ($schedules as $schedule)
                            <input type="checkbox" id="{{ 'schedule_' . $schedule->id }}" name="schedules[]" value="{{ $schedule->id }}"
                                   @if ($user_food_preferences && $user_food_preferences->schedules->contains($schedule))
                                   checked
                                @endif
                            >
                            <label for="{{ 'schedule_' . $schedule->id }}">{{ $schedule->schedule_type }}</label><br>
                        @endforeach
                    </div>
                    @error('schedules')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="food_types" class="col-md-4 col-form-label text-md-end @error('food_types') is-invalid @enderror">Food Types:</label>
                    <div class="col-md-6">
                        @foreach ($food_types as $food_type)
                            <input type="checkbox" id="{{ 'food_type_' . $food_type->id }}" name="food_types[]" value="{{ $food_type->id }}"
                                   @if ($user_food_preferences && $user_food_preferences->food_types->contains($food_type))
                                   checked
                                @endif
                            >
                            <label for="{{ 'food_type_' . $food_type->id }}">{{ $food_type->name }}</label><br>
                        @endforeach
                    </div>
                    @error('food_types')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="price_ranges" class="col-md-4 col-form-label text-md-end @error('price_ranges') is-invalid @enderror">Price Ranges:</label>
                    <div class="col-md-6">
                        @foreach ($price_ranges as $price_range)
                            <input type="checkbox" id="{{ 'price_range_' . $price_range->id }}" name="price_ranges[]" value="{{ $price_range->id }}"
                                   @if ($user_food_preferences && $user_food_preferences->price_ranges->contains($price_range))
                                   checked
                                @endif
                            >
                            <label for="{{ 'price_range_' . $price_range->id }}">{{ $price_range->range }}</label><br>
                        @endforeach
                    </div>
                    @error('price_ranges')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script>
        $('#location').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{route('users.search.location')}}",
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
