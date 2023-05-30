@extends('layouts.app')

@section('title', 'Search')

@section('content')

    <!-- Header -->
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Search</h1>
        </div>
    </div>

    <!-- Search -->
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
                        <form action="{{ route('search_with_filters') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            <select id="filter-search-text" name="filter_search_text"
                                                    class="form-select custom-select" onChange="handle_sort_by_options()">
                                                <option value="name" @if(!@isset($is_get)){{ old('filter_search_text', $request->input('filter_search_text')) == "name" ? 'selected' : '' }}@endif>Name</option>
                                                <option value="description" @if(!@isset($is_get)){{ old('filter_search_text', $request->input('filter_search_text')) == "description" ? 'selected' : '' }}@endif>Description</option>
                                                <option value="location" @if(!@isset($is_get)){{ old('filter_search_text', $request->input('filter_search_text')) == "location" ? 'selected' : '' }} @elseif (@isset($is_get) && @isset($has_results)) {{ old('search_location_input', $request->input('search_location_input')) != "" ? 'selected' : '' }} @endif>Location</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group mb-3">
                                                <input type="text" id="search-text" name="search_text" @if(!@isset($is_get)) value="{{ old('search_text', $request->input('search_text')) }}" @elseif (@isset($is_get) && @isset($has_results)) value="{{ old('search_location_input', $request->input('search_location_input')) }}" @endif
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
                                        <select id="food-types" name="food_types[]"
                                                class="multiselect form-control form-select" multiple data-live-search="true"
                                                data-selected-text-format="count > 2">
                                            @foreach ($food_types as $food_type)
                                                <option value="{{$food_type->id}}">{{$food_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price-ranges">Price Range</label>
                                        <select id="price-ranges" name="price_ranges[]"
                                                class="multiselect form-control form-select" multiple>
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
                                                <label for="schedules">Schedule</label>
                                                <select id="schedules" name="schedules[]"
                                                        class="multiselect form-control form-select" multiple>
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
                                            <option value="2" @if(!@isset($is_get)){{ old('terrace', $request->input('terrace')) == "2" ? 'selected' : '' }}@endif>Indifferent</option>
                                            <option value="1" @if(!@isset($is_get)){{ old('terrace', $request->input('terrace')) == "1" ? 'selected' : '' }}@endif>Yes</option>
                                            <option value="0" @if(!@isset($is_get)){{ old('terrace', $request->input('terrace')) == "0" ? 'selected' : '' }}@endif>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sort-by">Sort By</label>
                                        <select id="sort-by" name="sort_by" class="form-select">
                                            <option value="rating" @if(!@isset($is_get)){{ old('sort_by', $request->input('sort_by')) == "rating" ? 'selected' : '' }}@endif>Rating</option>
                                            @if(Auth::check() || (!@isset($is_get) && (old('sort_by', $request->input('sort_by')) == 'nearest' || old('search_text', $request->input('search_text') == 'farthest'))))
                                                <option value="nearest" @if(!@isset($is_get)){{ old('sort_by', $request->input('sort_by')) == "nearest" ? 'selected' : '' }}@endif>Nearest</option>
                                                <option value="farthest" @if(!@isset($is_get)){{ old('sort_by', $request->input('sort_by')) == "farthest" ? 'selected' : '' }}@endif>Farthest</option>
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
            @if(!@isset($is_get) || (@isset($is_get) && @isset($has_results) && @isset($restaurants)))
                <div class="row g-5 align-items-center">
                    <div class="container px-5 pt-3">
                        <div class="row justify-content-between mb-3">
                            <div class="col-auto align-self-center">
                                <h2>Results</h2>
                            </div>
                        </div>
                        @if(@isset($restaurants) && $restaurants->count() > 0)
                            @php $count = 0; @endphp
                            @foreach ($restaurants as $restaurant)
                                @if($count % 3 === 0)
                                    <div class="results-row row">
                                        @endif
                                        <div class="col-lg-4 mb-4">
                                            <div class="card">
                                                <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                                    <img class="card-img-top img-fluid"
                                                         src="{{asset('storage/' . $restaurant->main_image_url)}}" alt="{{$restaurant->name}}"/>
                                                </a>
                                                <div class="card-body">
                                                    <div class="card-title justify-content-between align-self-center">
                                                        <div class="title">
                                                            <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                                                <h5>{{$restaurant->name}}</h5>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <p class="card-text">{{$restaurant->description}}</p>
                                                </div>
                                                @if(@isset($restaurant->distance))
                                                    <div class="card-footer justify-content-between">
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
                                                        <small class="text-muted">{{$restaurant->distance}} km</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $count++;
                                        @endphp
                                        @if($count % 3 === 0 || $loop->last)
                                    </div>
                                @endif
                            @endforeach
                            <div class="d-flex justify-content-center mb-5 mt-4 reviews-pagination">
                                {{ $restaurants->links() }}
                            </div>
                        @else
                            <div class="no-results p-5"> There are no results for the selected filters.</div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.multiselect').selectpicker();

            @if(!@isset($is_get))
            var food_types = {!! json_encode(old('food_types', $request->input('food_types', []))) !!};
            var price_ranges = {!! json_encode(old('price_ranges', $request->input('price_ranges', []))) !!};
            var schedules = {!! json_encode(old('schedules', $request->input('schedules', []))) !!};

            if (food_types.length > 0) {
                $('#food-types').selectpicker('val', food_types);
            }

            if (price_ranges.length > 0) {
                $('#price-ranges').selectpicker('val', price_ranges);
            }

            if (schedules.length > 0) {
                $('#schedules').selectpicker('val', schedules);
            }
            @endif

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
