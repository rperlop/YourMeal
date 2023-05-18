@extends('admin.layouts.app', ['activePage' => 'reviews', 'title' => 'List of reviews', 'navName' => 'Reviews'])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List of reviews</h1>
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

                    <table class="table table-bordered" id="user_table">
                        <thead>
                        <tr>
                            <th>Review ID</th>
                            <th>Restaurant</th>
                            <th>User</th>
                            <th>Created at</th>
                            <th>Total Reports</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{$review->restaurant->name}}</td>
                                <td>{{$review->user_id}}</td>
                                <td>{{$review->created_at}}</td>
                                <td>{{$review->reports->count()}}</td>
                                <td>
                                    <a href="{{ route('show-review', $review->id) }}" class="btn btn-success">
                                        Show
                                    </a>
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
