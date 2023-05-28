@extends('admin.layouts.app', ['activePage' => 'configuration', 'title' => 'Configuration', 'navName' => 'Configuration'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-4">Admin policy</p>
                            <form method="POST" action="{{route('update.configuration')}}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="compulsive_number" class="required">Compulsive number (max. reports per 1 hour)</label>
                                    <input type="text" name="compulsive_number" id="compulsive_number" class="form-control" value="{{ $config->where('property', 'compulsive_number')->first()->value ?? '' }}">
                                    @if ($errors->has('compulsive_number'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('compulsive_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="strikes_number" class="required">Strikes number (max. strikes for being banned)</label>
                                    <input type="text" name="strikes_number" id="strikes_number" class="form-control" value="{{ $config->where('property', 'strikes_number')->first()->value ?? '' }}">
                                    @if ($errors->has('strikes_number'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('strikes_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="reports_min_number" class="required">Reports number (min. reports in a review for being noticed)</label>
                                    <input type="text" name="reports_min_number" id="reports_min_number" class="form-control" value="{{ $config->where('property', 'reports_min_number')->first()->value ?? '' }}">
                                    @if ($errors->has('reports_min_number'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('reports_min_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-4">Add new Food Type</p>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <label for="name">These are the existing food types</label>
                                    <div class="form-group">
                                        <select class="form-control">
                                            @foreach($food_types as $food_type)
                                                <option value="{{ $food_type->id }}">{{ $food_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('store.food_type') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="required">Food type name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
