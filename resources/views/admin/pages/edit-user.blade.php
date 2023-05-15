@extends('admin.layouts.app', ['activePage' => 'user-management', 'title' => 'Edit user', 'navName' => 'Edit user', 'activeButton' => 'laravel'])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit user</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-4">User data</p>
                            <form method="POST" action="#">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="first_name" class="required">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control {{$errors->has('first_name') ? 'is-invalid' : ''}}" value="{{old('first_name', $user->first_name)}}">
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="required">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control {{$errors->has('last_name') ? 'is-invalid' : ''}}" value="{{old('last_name', $user->last_name)}}">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email" class="required">Email </label>
                                    <input type="email" name="email" id="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" value="{{old('email', $user->email)}}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password" class="required">Password </label>
                                    <input type="password" name="password" id="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="role" class="required">Role</label>
                                    <div class="form-floating @error('role') is-invalid @enderror">
                                        <select class="form-select" id="role" name="role">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <a class="btn btn-danger" href="{{url( '/admin/pages/index-users')}}">
                                            <i class="fa fa-fw fa-lg fa-arrow-left"></i>
                                            Go back
                                        </a>
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
        </div>
    </div>
@endsection
