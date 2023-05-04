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

                <div>
                    <h2>Agregar reseña</h2>
                    <form method="POST" action="{{ route('review.store', $restaurant->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="rating">Calificación:</label>
                            <input type="number" name="rating" min="0" max="5" required>
                        </div>
                        <div>
                            <label for="comment">Comentario:</label>
                            <textarea name="comment" required></textarea>
                        </div>
                        <div>
                            <label for="images">Imágenes:</label>
                            <input type="file" name="images[]" multiple>
                        </div>
                        <button type="submit">Enviar</button>
                    </form>
                </div>


            </div>
         {{--   @if(Auth::check())
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                    <div class="form-group">
                        <label for="comment">Write your comment:</label>
                        <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            @endif--}}
        </div>
    </div>

@endsection
