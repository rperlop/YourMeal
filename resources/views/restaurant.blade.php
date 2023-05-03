@extends('layouts.app')

@section('title', 'Restaurant Page')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Restaurant card</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <img src="{{asset('img/burger.jpg')}}" alt="{{ $restaurant->name }}"/>
                    <h1>{{ $restaurant->name }}</h1>
                    <p>{{ $restaurant->address }}</p>
                    <p>{{ $restaurant->phone_number }}</p>
                    <p>{{ $restaurant->description }}</p>
                    <p><a href="{{ $restaurant->web }}">{{ $restaurant->web }}</a></p>
                    <p><strong>Schedule:</strong></p>
                    <ul>
                        @foreach ($restaurant->schedules as $schedule)
                            <li>{{ $schedule->schedule_type }}</li>
                        @endforeach
                    </ul>
                    <p><strong>Terrace:</strong> {{ $restaurant->terrace ? 'Yes' : 'No' }}</p>
                    <p><strong>Price Range:</strong> {{ $price_range }}</p>
                    <p><strong>Food Types:</strong></p>
                    <ul>
                        @foreach ($restaurant->food_types as $food_type)
                            <li>{{ $food_type->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="height-100 container d-flex justify-content-center align-items-center">

                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h5 class="review-count">12 Reviews</h5>
                        </div>


                        <div class="mt-5 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">Cleanliness</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>

                        </div>

                        <div class="mt-1 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">Approachability of SLT</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>


                        <div class="mt-1 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">Front Office</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>


                        <div class="mt-1 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">CPD</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                            </div>
                        </div>


                        <div class="mt-1 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">Pastrol</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>

                        <div class="mt-1 d-flex justify-content-between align-items-center">
                            <h5 class="review-stat">Office Space</h5>
                            <div class="small-ratings">
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star rating-color"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            @if(Auth::check())
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                    <div class="form-group">
                        <label for="comment">Write your comment:</label>
                        <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            @endif
        </div>
    </div>

@endsection
