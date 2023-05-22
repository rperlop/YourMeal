@extends('admin.layouts.app', ['activePage' => 'user-management', 'title' => 'List of users', 'navName' => 'User management'])

@section('content')
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
                    <a href="{{ route('admin.create.user') }}" class="btn btn-primary mb-3">New user</a>

                    <table class="table table-bordered" id="user_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="{{ route('admin.edit.user', $user->id) }}" class="btn btn-success">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.destroy.user', $user->id) }}" id="delete_form" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline-block;">
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

