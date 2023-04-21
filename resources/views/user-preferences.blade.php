@extends('layouts.app')

@section('title', 'Food Preferences')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Food preferences</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-0">
            <form method="POST" action="{{ route('user_preferences.update') }}" id="signUpForm">
                @csrf
                @method('PATCH')
                <div class="row mb-3">
                    <label for="location" class="col-md-4 col-form-label text-md-end">City:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="location" value="{{ $location }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="terrace" class="col-md-4 col-form-label text-md-end">Terrace:</label>
                    <div class="col-md-6">
                        <select class="form-select" id="terrace" name="terrace">
                            <option value="2" {{ $terrace ? 'selected' : '' }}>Yes, I love it</option>
                            <option value="1" {{ !$terrace ? 'selected' : '' }}>No, please, let me inside</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="schedules" class="col-md-4 col-form-label text-md-end">Schedules:</label>
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
                </div>
                <div class="row mb-3">
                    <label for="food_types" class="col-md-4 col-form-label text-md-end">Food Types:</label>
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
                </div>
                <div class="row mb-3">
                    <label for="price_ranges" class="col-md-4 col-form-label text-md-end">Price Ranges:</label>
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
                </div>
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

@endsection
