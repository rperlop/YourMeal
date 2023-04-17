@extends('layouts.app')

@section('title', 'Food Preferences')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Food preferences</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">

        <form method="POST" action="{{ route('user-preferences.update') }}">
            @csrf
            @method('PUT')

            <label for="latitude">Latitude:</label>
            <input type="text" name="latitude" value="{{ $user->user_food_preferences->latitude }}">

            <label for="longitude">Longitude:</label>
            <input type="text" name="longitude" value="{{ $user->user_food_preferences->location }}">

            <label for="terrace">Terrace:</label>
            <input type="checkbox" name="terrace" value="1" {{ $user->user_food_preferences->terrace ? 'checked' : '' }}>

            <label for="schedules">Schedules:</label>
            <select name="schedules[]" multiple>
                @foreach($user->user_food_preferences->schedules as $schedule)
                    <option value="{{ $schedule->id }}" selected>{{ $schedule->name }}</option>
                @endforeach
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}">{{ $schedule->name }}</option>
                @endforeach
            </select>

            <label for="food_types">Food Types:</label>
            <select name="food_types[]" multiple>
                @foreach($user->user_food_preferences->food_types as $food_type)
                    <option value="{{ $food_type->id }}" selected>{{ $food_type->name }}</option>
                @endforeach
                @foreach($food_types as $food_type)
                    <option value="{{ $food_type->id }}">{{ $food_type->name }}</option>
                @endforeach
            </select>

            <label for="price_ranges">Price Ranges:</label>
            <select name="price_ranges[]" multiple>
                @foreach($user->user_food_preferences->price_ranges as $price_range)
                    <option value="{{ $price_range->id }}" selected>{{ $price_range->name }}</option>
                @endforeach
                @foreach($price_ranges as $price_range)
                    <option value="{{ $price_range->id }}">{{ $price_range->name }}</option>
                @endforeach
            </select>

            <button type="submit">Save</button>
        </form>
    </div>


@endsection
