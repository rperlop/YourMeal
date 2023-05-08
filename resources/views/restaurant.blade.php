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
                                        <strong> {{ $review->user->first_name }} {{ $review->user->last_name }} </strong>
                                    </p>
                                    <p class="font-weight-bold ">
                                        <strong> {{ $review->created_at }}</strong>
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

            <div class="container">
                @foreach($reviews as $review)
                <div class="row">
                        <div class="media g-mb-30 media-comment">
                            <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                                <div class="g-mb-15">
                                    <h5 class="h5 g-color-gray-dark-v1 mb-0">{{ $review->user->first_name }} {{ $review->user->last_name }} </h5>
                                    <span class="g-color-gray-dark-v4 g-font-size-12">{{ $review->created_at }}</span>
                                </div>
                                <br>
                                <p>{{ $review->comment }}</p>

                                <div class="container">
                                    @foreach ($review->images as $image)
                                    <div class="superbox">
                                        <div class="superbox-list">
                                            <img src="{{ asset('storage/img/' . $image->name) }}"  alt="{{ $image->name }}" class="superbox-img">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="modal fade" id="showPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-inline d-sm-flex my-0">
                                    @if($review->user_id == auth()->user()->id)
                                        <li class="list-inline-item g-mr-20">
                                            <button class="btn btn-primary edit-button" data-comment-id="{{ $review->id }}" data-toggle="modal" data-target="#editModal-{{ $review->id }}">Editar</button>
                                        </li>
                                    @else
                                    <li class="list-inline-item ml-auto">
                                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">
                                            <i class="fa fa-report g-pos-rel g-top-1 g-mr-3"></i>
                                            Report
                                        </a>
                                    </li>
                                        @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <div class="modal fade" id="editModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $review->id }}">                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $review->id }}">Editar comentario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('reviews.update', ['id' => $review->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="comment">Comentario</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3">{{ $review->comment }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="images">Imágenes</label>
                                        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
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
                                        <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star">5</label>
                                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star">4</label>
                                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star">3</label>
                                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star">2</label>
                                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">1</label>
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

            $(function(){
                $('.superbox-img').click(function(){
                    $('#showPhoto .modal-body').html($(this).clone());
                    $('#showPhoto').modal('show');
                })
            })

            $(document).ready(function() {
                // Obtener el botón de editar y el modal
                var editButton = $('#edit-button');
                var editModal = $('#edit-modal');

                // Asignar evento click al botón de editar
                editButton.click(function() {
                    // Mostrar el modal
                    editModal.modal('show');
                });
            });
        </script>

@endsection
