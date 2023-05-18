@extends('layouts.app')

@section('title', 'Restaurant Page')

@section('content')


    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Restaurant</h1>
        </div>
    </div>


    <div class="container-xxl bg-white p-0">
        <div class="container">

            <div class="row g-5 align-items-center restaurant-container">
                <div class="col-lg-6">
                    <div class="row g-3">
                        <img src="{{ asset('storage/' . $restaurant->main_image_url)}}" alt="{{ $restaurant->name }}" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <h1>{{ $restaurant->name }}</h1>

                        @php $rating = $avg_rating; @endphp

                        <p class="mb-4"><span class="rating">
                            @foreach(range(1,5) as $i)
                                    <span class="fa-stack" style="width:1em">
                                <i class="far fa-star fa-stack-1x"></i>
                                @if($rating >0)
                                            @if($rating >0.5)
                                                <i class="fas fa-star fa-stack-1x"></i>
                                            @else
                                                <i class="fas fa-star-half fa-stack-1x"></i>
                                            @endif
                                        @endif
                                        @php $rating--; @endphp
                            </span>
                                @endforeach
                        </span> {{ $price_range }} </p>

                        <p class="mb-4 restaurant-description">{{ $restaurant->description }}</p>
                        <div class="row restaurant-details">
                            <div class="col-lg-6 mb-4">
                                <div class="service-item rounded pt-3">
                                    <h5 class="mb-4">Location and contact</h5>
                                    <p><i class="fa fa-fw fa-location-dot text-primary me-2"></i>{{ $restaurant->address }}
                                    </p>
                                    <p><i class="fa fa-fw fa-phone text-primary me-2"></i>{{ $restaurant->phone_number }}
                                    </p>
                                    <p class="mb-4"><a href="{{ $restaurant->web }}"><i
                                                class="fa fa-fw fa-laptop text-primary me-2"></i>
                                            Web</a></p>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="service-item rounded pt-3">
                                    <h5 class="mb-4">More details</h5>
                                    <div class="mb-4">
                                        <div class="mb-2"><strong>Schedule:</strong></div>

                                        @foreach ($restaurant->schedules as $schedule)
                                            <div><i
                                                    class="fa-solid fa-fw fa-angles-right me-2"></i>{{ $schedule->schedule_type }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <p><strong>Terrace:</strong> {{ $restaurant->terrace ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-4">
                            <p class="mb-2"><strong>Food Types:</strong></p>
                            @foreach(array_chunk($restaurant->food_types->toArray(), 4) as $group)
                                <div class="row">
                                    @foreach ($group as $food_type)
                                        <div class="col-auto">
                                            <div class="service-item rounded food-type">
                                                {{ $food_type['name'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>



            @if (auth()->check())

                @php $updating = 0; @endphp

                @if($user_has_review)
                    @php $updating = 1; @endphp
                @endif

                <div class="modal fade" id="reviewForm" tabindex="-1" aria-labelledby="modal-review" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-review">My review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('review.store', ['restaurant' => $restaurant->id, 'updating' => $updating]) }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input class="rating rating-form" name="rate" id="rate" data-plugin_simpleRating="simpleRating_instance">
                                    </div>
                                    <div class="form-group mb-3">
                                        @if($user_has_review)
                                            <textarea class="form-control" id="description" name="description"
                                                      placeholder="Description" rows="3">{{ $user_review->comment }}</textarea>
                                        @else
                                            <textarea class="form-control" id="description" name="description"
                                                      placeholder="Description" rows="3"></textarea>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <label for="images" class="form-label">Images</label>
                                            <input type="file" class="form-control" id="images" name="images[]" accept=".jpg,.gif,.png,.tif,.jpeg" multiple>
                                            @if($user_has_review)

                                                @isset($user_review->images)
                                                    @foreach ($user_review->images as $imageName)
                                                        <input type="hidden" name="existingImages[]" value="{{ $imageName }}">
                                                    @endforeach
                                                @endisset

                                            @endif
                                        </div>
                                        <div class="image-preview mt-3 mb-3"></div>
                                    </div>
                                    <div class="modal-footer d-block">
                                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            @endif



            <div class="row g-5 align-items-center">
                <div class="container container px-5 pt-3">
                    <div class="row justify-content-between mb-3">
                        <div class="col-auto align-self-center">
                            <h2>Reviews</h2>
                        </div>
                        @if (auth()->check() && !$user_has_review)
                            <div class="col-auto align-self-center">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#reviewForm">
                                    Create a review
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="review-block">
                        @foreach($reviews as $review)
                            <div class="row service-item p-3 mb-4">
                                <div class="col-sm-2">
                                    <div class="review-block-name">{{ $review->user->first_name }}
                                        {{ $review->user->last_name }}
                                    </div>
                                    <div class="review-block-date mb-4">{{ $review->updated_at }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end">
                                        @if (auth()->check() && ($user_review_in_page && !$loop->first) || (auth()->check() && !$user_review_in_page))
                                            <div class="review-block-report"><a href="{{ route('report.report', $review) }}">Report</a>
                                            </div>
                                        @elseif (auth()->check() && $user_review_in_page && $loop->first)
                                            <div class="review-block-edit"><a href="#" data-bs-toggle="modal"
                                                                              data-bs-target="#reviewForm">Edit your review</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="rating mb-3">
                                        @php $rating = $review->rate; @endphp
                                        @foreach(range(1,5) as $i)
                                            <span class="fa-stack" style="width:1em">
                                    <i class="far fa-star fa-stack-1x"></i>
                                    @if($rating >0)
                                                    @if($rating >0.5)
                                                        <i class="fas fa-star fa-stack-1x"></i>
                                                    @else
                                                        <i class="fas fa-star-half fa-stack-1x"></i>
                                                    @endif
                                                @endif
                                                @php $rating--; @endphp
                                </span>
                                        @endforeach
                                    </div>
                                    <div class="review-block-description mb-3">{{ $review->comment }}</div>
                                    <div class="review-block-images">
                                        @foreach ($review->images as $image)
                                            <a href="{{ asset('storage/img/' . $image->name) }}"
                                               data-lightbox="photos-{{$review->id}}">
                                                <img class="img-thumbnail mb-2" src="{{ asset('storage/img/' . $image->name) }}"
                                                     alt="{{$image->name}}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mb-4 reviews-pagination">
                        {{ $reviews->links() }}
                    </div>

                </div>
            </div>


        </div>

        @if (session('formSubmitted') && count($errors) > 0)
            <script>
                $(document).ready(function () {
                    $('#reviewForm').modal('show');
                });
            </script>
        @endif

        @if (auth()->check())

            <script>

                $(document).ready(function () {
                    $('.rating-form').rating();
                });

                $(function() {
                    $('#images').on('change', function() {
                        $('.image-preview').html('');
                        var files = $(this).prop('files');
                        for (var i = 0; i < files.length; i++) {
                            var reader = new FileReader();
                            reader.onload = function(e) {

                                var img = $('<img>', {
                                    src: e.target.result,
                                    class: 'img-thumbnail',
                                    style: 'width: 150px; height: 150px;'
                                });

                                $('.image-preview').append(img);
                            }
                            reader.readAsDataURL(files[i]);
                        }
                    });
                });

            </script>

            @if ($user_has_review)
                <script>
                    $(document).ready(function () {
                        if({{$user_has_review}}){
                            var user_rate = {{$user_review->rate}};
                            $('[data-rating="' + user_rate + '"]').eq(0).click();
                            if({{ $user_review->images != null}}){
                                $('.image-preview').html('');

                                var images = {!! json_encode($user_review->images) !!};
                                for (var i = 0; i < images.length; i++) {
                                    var img = $('<img>', {
                                        src: "{{ asset('storage/img/') }}/" + images[i].name,
                                        class: 'img-thumbnail',
                                        style: 'width: 150px; height: 150px;'
                                    });
                                    $('.image-preview').append(img);
                                }
                            }

                        }
                    });
                </script>
    @endif

    @endif

@endsection
