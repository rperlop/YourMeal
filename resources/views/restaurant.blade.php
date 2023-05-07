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
                    <p>Average rate: {{ $avg_rating }}</p>
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

                <div class="container">
                    <h2>Reviews</h2>
                    @foreach($reviews as $review)
                        <div class="card">
                        <div class="row">
                            <div class="col mt-6">
                                <div>
                                    <p class="font-weight-bold ">
                                        <strong> {{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                                    </p>
                                    <div class="form-group row">
                                        <input type="hidden" name="rating" value="{{ $review->rate }}">
                                        <div class="col">
                                            <div class="rated">
                                                @for($i=1; $i<=$review->rate; $i++)
                                                    <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/>
                                                    <label class="star-rating-complete" title="text">{{$i}} stars</label>
                                                @endfor
                                            </div>
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                        @foreach ($review->images as $image)
                                            <div class="col-md-4">
                                                <img src="{{ asset('storage/img/' . $image->name) }}" alt="{{ $image->name }}" class="img-thumbnail">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            </div>
                            @endforeach
                        </div>
                </div>
            </div>

            @if (auth()->check() && !$restaurant->reviews()->where('user_id', auth()->user()->id)->exists())
            <div class="container">
                <div class="row">
                    <div class="col mt-4">
                        <form class="py-2 px-4" action="{{ route('review.store', $restaurant->id) }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <p class="font-weight-bold ">Review</p>
                            <div class="form-group row">
                                <input type="hidden" name="rating" id="rating-input" value="{{ $review->rate }}">
                                <div class="col">
                                    <div class="rate">
                                        <input type="radio" id="star5" class="rate" name="rate" value="5" onclick="updateRating(5)" {{ old('rate') == 5 ? 'checked' : '' }}/>
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" class="rate" name="rate" value="4" onclick="updateRating(4)" {{ old('rate') == 4 ? 'checked' : '' }}/>
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" class="rate" name="rate" value="3" onclick="updateRating(3)" {{ old('rate') == 3 ? 'checked' : '' }}/>
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" class="rate" name="rate" value="2" onclick="updateRating(2)" {{ old('rate') == 2 ? 'checked' : '' }}/>
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" class="rate" name="rate" value="1" onclick="updateRating(1)" {{ old('rate') == 1 ? 'checked' : '' }}/>
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col">
                                    <textarea class="form-control" name="comment" rows="6 " placeholder="Comment" maxlength="200"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col">
                                    <label for="images">Upload Images:</label>
                                    <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                                </div>
                            </div>
                            <div class="mt-3 text-right">
                                <button class="btn btn-sm py-2 px-3 btn-info">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <script>
            function updateRating(rating) {
                document.getElementById("rating-input").value = rating;
            }
        </script>

@endsection
