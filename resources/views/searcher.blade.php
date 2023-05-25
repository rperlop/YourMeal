@extends('layouts.app')

@section('title', 'Search')

@section('content')


    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Search</h1>
        </div>
    </div>

    <div class="container-xxl bg-white p-0">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="container px-5 pt-3">
                    <div class="row service-item mb-4 px-3 py-4">
                        <div class="row justify-content-between mb-3">
                            <div class="col-auto align-self-center">
                                <h2>Search restaurants</h2>
                            </div>
                        </div>
                        <form action="{{ route('search_with_filters') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            <select id="filter-search-text" name="filter_search_text" class="form-select custom-select" onChange="handle_sort_by_options()">
                                                <option value="name">Name</option>
                                                <option value="description">Description</option>
                                                <option value="location">Location</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group mb-3">
                                                <input type="text" id="search-text" name="search_text"
                                                       class="form-control ui-autocomplete-input custom-input"
                                                       placeholder="Search keyword"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="food-types">Food Type</label>
                                        <select id="food-types" name="food_types[]" class="multiselect form-control form-select" multiple
                                                data-live-search="true" data-selected-text-format="count > 2">
                                            @foreach ($food_types as $food_type)
                                                <option value="{{$food_type->id}}">{{$food_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price-range">Price Range</label>
                                        <select id="price-range" name="price_ranges[]" class="multiselect form-control form-select" multiple>
                                            @foreach ($price_ranges as $price_range)
                                                <option value="{{$price_range->id}}">{{$price_range->range}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="schedule">Schedule</label>
                                                <select id="schedule" name="schedules[]" class="multiselect form-control form-select" multiple>
                                                    @foreach ($schedules as $schedule)
                                                        <option value="{{$schedule->id}}">{{$schedule->schedule_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="terrace">Terrace</label>
                                        <select id="terrace" name="terrace" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <option value="2">Indifferent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sort-by">Sort By</label>
                                        <select id="sort-by" name="sort_by" class="form-select">
                                            <option value="rating">Rating</option>
                                            @if(Auth::check())
                                                <option value="nearest">Nearest</option>
                                                <option value="farthest">Farthest</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto ms-auto">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(!@isset($is_get))
                <div class="row g-5 align-items-center">
                    <div class="container px-5 pt-3">
                        <div class="row justify-content-between mb-3">
                            <div class="col-auto align-self-center">
                                <h2>Results</h2>
                            </div>
                        </div>
                        @if(@isset($restaurants))
                            @foreach ($restaurants as $key=>$restaurant)
                                @if($key % 3 === 0)
                                    <div class="card-deck">
                                        @endif
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="{{asset('storage/' . $restaurant->main_image_url)}}" alt="{{$restaurant->name}}"/>
                                            <div class="card-body">
                                                <div class="card-title justify-content-between align-self-center">
                                                    <div class="title"><h5>{{$restaurant->name}}</h5></div>
                                                    <div class="restaurant-rate-price">
                                <span class="rating">
                                    @foreach(range(1,5) as $i)
                                        <span class="fa-stack" style="width:1em">
                                        <i class="far fa-star fa-stack-1x"></i>
                                        @if($restaurant->reviews_avg_rate >0)
                                                @if($restaurant->reviews_avg_rate >0.5)
                                                    <i class="fas fa-star fa-stack-1x"></i>
                                                @else
                                                    <i class="fas fa-star-half fa-stack-1x"></i>
                                                @endif
                                            @endif
                                            @php $restaurant->reviews_avg_rate--; @endphp
                                        </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <p class="card-text">{{$restaurant->description}}</p>
                                            </div>
                                            @if(@isset($restaurant->distance))
                                                <div class="card-footer">
                                                    <small class="text-muted">{{$restaurant->distance}} km</small>
                                                </div>
                                            @endif
                                        </div>
                                        @if(($key + 1) % 3 === 0 || $loop->last)
                                    </div>
                                @endif
                            @endforeach
                            <div class="d-flex justify-content-center mb-4 reviews-pagination">
                                {{ $restaurants->links() }}
                            </div>
                        @else
                            <div> No results.</div>
                        @endif
                    </div>
                </div>
            @endif
        </div>


    </div>

    <script>
        $(document).ready(function () {
            $('.multiselect').selectpicker();

            $('#filter-search-text').change(function () {
                if ($('#filter-search-text').val() === 'location') {
                    $('#search-text').autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "{{route('search_location_page')}}",
                                dataType: 'json',
                                data: {
                                    query: request.term
                                },
                                success: function (data) {
                                    response(data)
                                }
                            });
                        },
                        minLength: 3,
                        delay: 250
                    });
                } else if ($('#search-text').data('ui-autocomplete')) {
                    $('#search-text').autocomplete('destroy');
                }
            });
        });

        function handle_sort_by_options() {
            @if(!Auth::check())
            var sort_by_select = document.getElementById('sort-by');
            var filter_search_text = document.getElementById('filter-search-text');

            var option = filter_search_text.value;

            sort_by_select.options.length = 1;

            if (option === 'location') {
                var nearestOption = document.createElement('option');
                nearestOption.value = 'nearest';
                nearestOption.text = 'Nearest';
                sort_by_select.add(nearestOption);

                var farthestOption = document.createElement('option');
                farthestOption.value = 'farthest';
                farthestOption.text = 'Farthest';
                sort_by_select.add(farthestOption);
            }
            @endif
        }

    </script>


@endsection
