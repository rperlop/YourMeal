@extends('admin.layouts.app', ['activePage' => 'reviews', 'title' => 'List of reviews', 'navName' => 'Reviews'])

@section('content')
    <div class="content">
        <div class="container-fluid">

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

