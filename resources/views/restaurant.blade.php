@extends('layouts.app')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Restaurant card</h1>
        </div>
    </div>

{{--    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <img src="{{ $restaurant->main_image_url }}" class="card-img-top" alt="Foto del restaurante">
                    <div class="card-body">
                        <h5 class="card-title">{{ $restaurant->name }}</h5>
                        <p class="card-text">{{ $restaurant->description }}</p>
                        <p class="card-text"><strong>Dirección:</strong> {{ $restaurant->address }}</p>
                        <p class="card-text"><strong>Teléfono:</strong> {{ $restaurant->phone_number }}</p>
                        <p class="card-text"><strong>Página web:</strong> <a href="{{ $restaurant->web }}" target="_blank">{{ $restaurante->pagina_web }}</a></p>
                        <p class="card-text"><strong>Nota media:</strong> {{ $restaurant->nota_media }}</p>
                        <p class="card-text"><strong>Tipo de comida:</strong> {{ $restaurant->tipo_comida }}</p>
                        <p class="card-text"><strong>Horario:</strong> {{ $restaurant->horario }}</p>
                        <p class="card-text"><strong>Terraza:</strong> {{ $restaurant->terraza ? 'Sí' : 'No' }}</p>
                        <h5 class="card-title">Comentarios de usuarios:</h5>
                        <ul class="list-group">
                            @foreach ($restaurant->comentarios as $comentario)
                                <li class="list-group-item">{{ $comentario }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @if($restaurants->isEmpty())
                    <p>There are no results.</p>
                @else
                <!-- Aquí va tu código de la vista actual -->
                    @foreach($restaurants as $result)
                        <div class="col-md-6 offset-md-3">
                            <div class="card">
                                <img src="{{asset('img/menu-1.jpg')}}" class="card-img-top" alt="Restaurant picture">
                                <div class="card-body">
                                    <h5 class="card-title">{{$result->name}}</h5>
                                    <p class="card-text"><strong>Address:</strong> </p>
                                    <p class="card-text"><strong>Phone:</strong> </p>
                                    <p class="card-text"><strong>Web:</strong> </p>
                                    <p class="card-text"><strong>Schedule:</strong> </p>
                                    <p class="card-text"><strong>Terrace:</strong> </p>
                                    <p class="card-text"><strong>Nota media:</strong> </p>
                                    <p class="card-text"><strong>Food Type:</strong> </p>
                                    <h5 class="card-title">Reviews:</h5>
                                    <ul class="list-group">
                                        <li>Hola soy Paco y no me gusta este sitio</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection
