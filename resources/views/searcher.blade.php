@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Search Results</h1>
        <form method="GET" action="{{ route('search') }}">
            <div class="form-group">
                <label for="query">Search:</label>
                <input type="text" name="query" id="query" class="form-control" placeholder="Search for restaurants...">
            </div>
            <div class="form-group">
                <label for="food_type">Food Type:</label>
                <select name="food_type[]" id="food_type" class="form-control" multiple>
                    @foreach($food_types as $food_type)
                        <option value="{{ $food_type->id }}">{{ $food_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="schedule">Schedule:</label>
                <select name="schedule[]" id="schedule" class="form-control" multiple>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="price_range">Price Range:</label>
                <select name="price_range[]" id="price_range" class="form-control" multiple>
                    @foreach($price_ranges as $price_range)
                        <option value="{{ $price_range->id }}">{{ $price_range->range }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <hr>
        @if(count($restaurants) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Food Type</th>
                    <th>Price Range</th>
                    <th>Rate</th>
                </tr>
                </thead>
                <tbody>
                @foreach($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->name }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td>{{ $restaurant->food_types->name }}</td>
                        <td>{{ $restaurant->price_ranges->range }}</td>
                        <td>{{ $restaurant->rate->average_rate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No restaurants found.</p>
        @endif
    </div>


@endsection
