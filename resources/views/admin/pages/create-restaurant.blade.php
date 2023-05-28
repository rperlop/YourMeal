@extends('admin.layouts.app', ['activePage' => 'restaurants', 'title' => 'Admin - New restaurant', 'navName' => 'New restaurant'])

@section('content')
    <div class="content">
        <div class="container-fluid data-form">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{route('create.restaurant')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="required">Name</label>
                                    <input type="text" name="name" id="name" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" value="{{old('name', '')}}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                             <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <div class="form-group">
                                        <label for="address" class="required">Address</label>
                                        <input type="text" name="address" id="address" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" value="{{old('address', '')}}">
                                        @if ($errors->has('address'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="web" class="required">Web</label>
                                        <input type="text" name="web" id="web" class="form-control {{$errors->has('web') ? 'is-invalid' : ''}}" value="{{old('web', '')}}">
                                        @if ($errors->has('web'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('web') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number" class="required">Phone number</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control {{$errors->has('phone_number') ? 'is-invalid' : ''}}" value="{{old('phone_number', '')}}">
                                        @if ($errors->has('phone_number'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="required">Email </label>
                                        <input type="email" name="email" id="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" value="{{old('email', '')}}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="required">Description</label>
                                        <textarea name="description" id="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" value="{{old('description', '')}}"></textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="main_image_url" class="required">Main Image</label>
                                        <input type="file" name="main_image_url" id="main_image_url" class="form-control-file {{$errors->has('main_image_url') ? 'is-invalid' : ''}}">
                                        @if ($errors->has('main_image_url'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('main_image_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div id="food-types-container">
                                        <p class="text-center mb-4">Food types</p>
                                        <div class="mb-3">
                                            @foreach(array_chunk($food_types->toArray(), 4) as $group)
                                                <div class="row">
                                                    @foreach($group as $food_type)
                                                        <div class="form-check mb-3 col-md-3 @error('food_types') is-invalid @enderror">
                                                            <input class="form-check-input" type="checkbox" name="food_types[]"
                                                                   value="{{ $food_type['id'] }}" id="{{ $food_type['name'] }}">
                                                            <label class="form-check-label text-wrap" for="{{ $food_type['name'] }}">
                                                                {{ $food_type['name'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    @error('food_types')
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div id="price-range-container">
                                        <p class="text-center mb-4">Price range</p>
                                        <div class="mb-3">
                                            <div class="row">
                                                @foreach($price_ranges as $price_range)
                                                    <div class="form-check mb-3 col-md-3 @error('price_ranges') is-invalid @enderror">
                                                        <input class="form-check-input" type="radio" name="price_ranges[]"
                                                               value="{{ $price_range->id }}" id="{{ $price_range->range }}">
                                                        @error('price_ranges')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label class="form-check-label" for="{{ $price_range->range }}">
                                                            {{ $price_range->range }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div id="schedule-container">
                                        <p class="text-center mb-4">Schedule</p>
                                        <div class="mb-3">
                                            <div class="row">
                                                @foreach($schedules as $schedule)
                                                    <div class="form-check mb-3 col-md-3 @error('schedules') is-invalid @enderror">
                                                        <input class="form-check-input" type="checkbox" name="schedules[]"
                                                               value="{{ $schedule->id }}" id="{{ $schedule->schedule_type }}">
                                                        @error('schedules')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label class="form-check-label" for="{{ $schedule->schedule_type }}">
                                                            {{ $schedule->schedule_type }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="terrace" class="required">Terrace </label>
                                            <div class="form-floating @error('terrace') is-invalid @enderror">
                                                <select class="form-select" id="terrace" name="terrace">
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                                @error('terrace')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location" class="required">Location </label>
                                            <input type="text" name="location" id="location" class="form-control ui-autocomplete-input" {{$errors->has('location') ? 'is-invalid' : ''}} placeholder="Search location">
                                            @if ($errors->has('location'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('location') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="row d-print-none mt-2">
                                            <div class="col-12 text-right">
                                                <a class="btn btn-danger" href="{{route('admin.index.restaurants')}}">
                                                    <i class="fa fa-fw fa-lg fa-arrow-left"></i>
                                                    Go back
                                                </a>
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#location').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{route('admin.search.location')}}",
                    dataType: 'json',
                    data: {
                        query: request.term
                    },
                    success: function(data){
                        response(data)
                    }
                });
            },
            minLength: 3,
            delay: 250
        });
    </script>

@endsection
