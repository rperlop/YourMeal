@extends('admin.layouts.app', ['activePage' => 'notifications', 'title' => 'List of notifications', 'navName' => 'Notifications'])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List of notifications</h1>
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

                    <table class="table table-bordered" id="notification_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{$notification->id }}</td>
                                @if($notification->type == 'compulsive_user')
                                <td>Compulsive user</td>
                                    @else
                                    <td>Reported review</td>
                                @endif
                                <td>{{$notification->created_at}}</td>
                                <td>
                                    <a href="{{ route('show-notification', $notification->id) }}" class="btn btn-success">
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
            $('#notification_table').DataTable({
                columnDefs: [
                    {
                        responsive: true
                    },
                ],
            });
        });
    </script>

@endsection

