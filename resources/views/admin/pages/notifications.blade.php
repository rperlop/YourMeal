@extends('admin.layouts.app', ['activePage' => 'notifications', 'title' => 'List of notifications', 'navName' => 'Notifications'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="notification_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(@isset($notifications))
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
                        @endif
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
