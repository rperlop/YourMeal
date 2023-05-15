@extends('admin.layouts.app', ['activePage' => 'restaurants', 'title' => 'List of restaurants', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List of restaurants</h1>
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
                    <a href="{{ route('create.restaurant') }}" class="btn btn-primary mb-3">New restaurant</a>

                    <table class="table table-bordered" id="user_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($restaurants as $restaurant)
                            <tr>
                                <td>{{$restaurant->name}}</td>
                                <td>{{$restaurant->phone_number}}</td>
                                <td>{{$restaurant->email}}</td>
                                <td>{{$restaurant->created_at}}</td>
                                <td>
                                    <a href="{{ route('edit.restaurant', $restaurant->id) }}" class="btn btn-success">
                                        Edit
                                    </a>

                                    <form action="{{ route('destroy.restaurant', $restaurant->id) }}" id="delete_form" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#user_table').DataTable({
                columnDefs: [
                    {
                        responsive: true
                    },
                ],
            });
        });
    </script>

@endsection

