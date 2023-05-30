@extends('admin.layouts.app', ['activePage' => 'user-management', 'title' => 'List of users', 'navName' => 'User management'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('admin.create.user') }}" class="btn btn-primary mb-3">New user</a>
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="user_table">
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
                                    <form id="deleteForm_{{ $user->id }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger deleteButton delete-form" type="button" data-toggle="modal" data-target="#delete-message" data-user-id="{{ $user->id }}">Delete</button>
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

    <!-- Modal -->
    <div class="modal fade" id="delete-message" tabindex="-1" role="dialog" aria-labelledby="delete-message-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-message-title">Attention!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger deleteButtonModal" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $('.deleteButton').click(function () {
            var userId = $(this).data('user-id');
            var deleteButtonModal = document.querySelector('.deleteButtonModal');

            deleteButtonModal.setAttribute('data-user-id', userId);

            var deleteMessageModal = new bootstrap.Modal(document.querySelector('#delete-message'));
            deleteMessageModal.show();
        });

        document.querySelector('.deleteButtonModal').addEventListener('click', function () {
            var userId = this.getAttribute('data-user-id');
            var deleteForm = document.querySelector('#deleteForm_' + userId);

            deleteForm.setAttribute('action', "{{ route('admin.destroy.user', ['id' => ':id']) }}".replace(':id', userId));
            deleteForm.setAttribute('method', 'POST');
            deleteForm.submit();
        });

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
