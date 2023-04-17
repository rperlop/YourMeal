@extends('layouts.app')

@section('title', 'Registration')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">User data</h1>
        </div>
    </div>

    <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-0">
            <form method="POST" action="{{ route('user.update') }}" id="signUpForm">
                @csrf
                @method('PUT')
                <div>
                    <label for="first_name">First name:</label>
                    <input type="text" name="first_name" value="{{ $user->first_name }}">
                </div>
                <div>
                    <label for="last_name">Last name:</label>
                    <input type="text" name="last_name" value="{{ $user->last_name }}">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="{{ $user->email }}">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button class="btn btn-primary" type="submit">Update data</button>
            </form>
            <form method="POST" action="{{ route('user.destroy') }}" onsubmit="return confirm('Are you sure? You will not be able to recover your account')">
                @csrf
                @method('DELETE')
                <button class="btn btn-primary" type="submit">Delete account</button>
            </form>
        </div>
    </div>

@endsection
