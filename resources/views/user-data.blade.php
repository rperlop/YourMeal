@extends('layouts.app')

@section('title', 'User data')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">User data</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-0">
            <form method="POST" action="{{ route('user.update') }}" id="signUpForm" class="login-sign-up-form">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="first_name" class="col-md-4 col-form-label text-md-end">First name:</label>
                    <div class="col-md-6">
                        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{ $user->first_name }}">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="last_name" class="col-md-4 col-form-label text-md-end">Last name:</label>
                    <div class="col-md-6">
                        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ $user->last_name }}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email:</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">Password:</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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
                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button class="btn btn-primary" type="submit">Update data</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mb-0">
            <form method="POST" action="{{ route('user.destroy') }}" id="signUpForm" class="login-sign-up-form" onsubmit="return confirm('Are you sure? You will not be able to recover your account')">
                @csrf
                @method('DELETE')
                <div class="row mb-0">
                    <p class="text-md">Do you want to remove your account? You won't get back it.</p>
                </div>

                <div class="col-md-8 offset-md-4">
                    <button class="btn btn-primary" type="submit">Delete account</button>
                </div>
            </form>

        </div>
    </div>

@endsection
