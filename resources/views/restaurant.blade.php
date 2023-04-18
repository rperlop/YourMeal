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
                <div class="card">
                    <img src="{{asset('img/menu-1.jpg')}}" class="card-img-top" alt="Foto del restaurante">
                    <div class="card-body">
                        <h5 class="card-title">Happy Burger</h5>
                        <p class="card-text">Happy Burger es un restaurante muy bonito</p>
                        <p class="card-text"><strong>Dirección:</strong> C/Mairena</p>
                        <p class="card-text"><strong>Teléfono:</strong> 955444333</p>
                        <p class="card-text"><strong>Página web:</strong> <a href="http://www.google.es" target="_blank">Web</a></p>
                        <p class="card-text"><strong>Nota media:</strong> 4.5</p>
                        <p class="card-text"><strong>Tipo de comida:</strong> Mexican</p>
                        <p class="card-text"><strong>Horario:</strong> Noche</p>
                        <p class="card-text"><strong>Terraza:</strong> Sí</p>
                        <h5 class="card-title">Comentarios de usuarios:</h5>
                        <ul class="list-group">
                            <li>Hola soy Paco y no me gusta este sitio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
