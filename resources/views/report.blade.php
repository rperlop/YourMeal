@extends('layouts.app')

@section('title', 'Report')

@section('content')
    <div class="container bg-white p-0">
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Report</h1>
            </div>
        </div>

        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                <form method="POST" action="{{ route('report.store') }}" id="report-form" class="login-sign-up-form">
                    @csrf
                    <div class="row mb-3">
                        <div class="form-group">
                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                            <input type="hidden" name="restaurant_id" value="{{ $review->restaurant_id }}">
                            <label for="reason" class="required col-form-label">Why do you report?</label>
                            <textarea name="reason" id="reason" class="form-control {{$errors->has('reason') ? 'is-invalid' : ''}}" value="{{old('reason', '')}}"></textarea>
                            @if ($errors->has('reason'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('reason') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-3">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-secondary">Go Back</a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Report') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

