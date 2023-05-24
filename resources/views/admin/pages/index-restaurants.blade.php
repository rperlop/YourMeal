@extends('admin.layouts.app', ['activePage' => 'restaurants', 'title' => 'List of restaurants', 'navName' => 'Restaurants'])

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

                                    <form id="deleteForm_{{ $restaurant->id }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger deleteButton delete-form" type="button" data-toggle="modal" data-target="#delete-message" data-restaurant-id="{{ $restaurant->id }}">Delete</button>
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
                    <p>Are you sure you want to remove this restaurant?</p>
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
            var userId = $(this).data('restaurant-id');
            var deleteButtonModal = document.querySelector('.deleteButtonModal');

            deleteButtonModal.setAttribute('data-restaurant-id', userId);

            var deleteMessageModal = new bootstrap.Modal(document.querySelector('#delete-message'));
            deleteMessageModal.show();
        });

        document.querySelector('.deleteButtonModal').addEventListener('click', function () {
            var restaurantId = this.getAttribute('data-restaurant-id');
            var deleteForm = document.querySelector('#deleteForm_' + restaurantId);

            deleteForm.setAttribute('action', "{{ route('destroy.restaurant', ['id' => ':id']) }}".replace(':id', restaurantId));
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

