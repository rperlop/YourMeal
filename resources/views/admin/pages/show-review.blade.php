@extends('admin.layouts.app', ['activePage' => 'reviews', 'title' => 'Admin - Show review', 'navName' => 'Show review'])

@section('content')

    <div class="container-xxl bg-white p-0">
        <div class="container">
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">Review #{{ $review->id }}</h4>
                    <div class="review-block">
                        <div class="row service-item p-3 mb-4">
                            <div class="col-sm-2">
                                <div class="review-block-date mb-4">User #{{ $review->user_id }} reviewed the restaurant #{{ $review->restaurant_id }}:
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="review-block-description mb-3">{{ $review->comment }}</div>
                                <div class="review-block-images">
                                    @foreach ($review->images as $image)
                                        <a href="{{ asset('storage/img/' . $image->name) }}"
                                           data-lightbox="photos-{{$review->id}}">
                                            <img class="img-thumbnail mb-2" src="{{ asset('storage/img/' . $image->name) }}"
                                                 alt="{{$image->name}}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-footer ">
                        <form id="deleteReviewForm" action="{{ route('reviews.delete', ['id' => $review->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="deleteReviewForm">Delete Review</button>
                        </form>
                        <form id="deleteReviewWithStrikeForm" action="{{ route('reviews.delete_with_strike', ['id' => $review->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="deleteReviewWithStrikeForm">Delete Review with Strike</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">Reports</h4>

                    @if ($review->reports->count() > 0)
                        <div class="container">
                            <div class="row g-5 align-items-center">
                                <div class="container container px-5 pt-3">
                                    @foreach ($review->reports as $report)
                                        <div class="review-block">
                                            <div class="row service-item p-3 mb-4">
                                                <div class="col-sm-2">
                                                    <div class="review-block-date mb-4">User #{{ $report->user_id }} reports:
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                    </div>
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="review-block-description mb-3">{{ $report->reason }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-footer ">
                                <form id="dismissReportsForm" action="{{ route('reviews.dismiss_reports', ['id' => $review->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="dismissReportsForm">Dismiss Reports</button>
                                </form>
                            </div>
                            @endif
                        </div>
                </div>
            </div>
            <a href="{{ url('/admin/pages/index-reviews') }}" class="btn btn-success">Go Back</a>
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
                        <p>Are you sure you want to remove this review?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger deleteButtonModal" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <script>

            $(document).ready(function () {
                var formId = null; // Variable para almacenar el ID del formulario a enviar
                var modalTitle = $('#delete-message-title');
                var modalMessage = $('#delete-message-body');

                $('.deleteButton').click(function () {
                    formId = $(this).data('form-id');
                    var buttonType = $(this).data('button-type');

                    // Actualiza el título y el mensaje del modal según el tipo de botón
                    if (buttonType === 'delete') {
                        modalTitle.text('Attention!');
                        modalMessage.text('Are you sure you want to delete this review?');
                    } else if (buttonType === 'dismiss') {
                        modalTitle.text('Dismiss Reports');
                        modalMessage.text('Are you sure you want to dismiss the reports for this item?');
                    }

                    $('#delete-message').modal('show');
                });

                $('.deleteButtonModal').click(function () {
                    if (formId !== null) {
                        var deleteForm = document.querySelector('#' + formId);
                        deleteForm.submit();
                        $('#delete-message').modal('hide');
                    }
                });
            });

            // Reinicia el formulario cuando se cierra el modal
            $('#delete-message').on('hidden.bs.modal', function () {
                formId = null; // Restablece el ID del formulario
                $('#delete-message').find('form').trigger('reset');
            });

            $(function () {
                $('#images').on('change', function () {
                    $('.image-preview').html('');
                    var files = $(this).prop('files');
                    for (var i = 0; i < files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function (e) {

                            var img = $('<img>', {
                                src: e.target.result,
                                class: 'img-thumbnail',
                                style: 'width: 150px; height: 150px;'
                            });

                            $('.image-preview').append(img);
                        }
                        reader.readAsDataURL(files[i]);
                    }
                });
            });

        </script>

@endsection
