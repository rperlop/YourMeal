@extends('admin.layouts.app', ['activePage' => 'notifications', 'title' => 'Admin - Show notification', 'navName' => 'Show notification'])

@section('content')

    <div class="container-xxl bg-white p-0">
        @if($notification->type == 'reported_review')
            <div class="container">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Review #{{ $review->id }} was reported several times</h4>
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
                                            <a href="#" data-toggle="modal" data-target="#image-modal-{{$image->id}}">
                                                <img class="img-thumbnail mb-2" src="{{ asset('storage/img/' . $image->name) }}"
                                                     alt="{{$image->name}}">
                                            </a>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="image-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="image-modal-title-{{$image->id}}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="image-modal-title-{{$image->id}}">{{$image->name}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/img/' . $image->name) }}" class="img-fluid" alt="{{$image->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                <button type="button" class="btn btn-danger deleteButton" data-button-type="deleteReview" data-toggle="modal" data-target="#delete-message" data-form-id="deleteReviewForm">Delete Review</button>
                            </form>
                            <form id="deleteReviewWithStrikeForm" action="{{ route('reviews.delete_with_strike', ['id' => $review->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger deleteButton" data-button-type="deleteReviewStrike" data-toggle="modal" data-target="#delete-message" data-form-id="deleteReviewWithStrikeForm">Delete Review with Strike</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Reports</h4>
                        <div class="container">
                            @if ($review->reports->count() > 0)
                                <div class="row g-5 align-items-center">
                                    <div class="container container px-5 pt-3">
                                        @foreach ($review->reports as $report)
                                            <div class="review-block">
                                                <div class="row service-item p-3 mb-4">
                                                    <div class="col-sm-2">
                                                        <div class="review-block-date mb-4">User #{{ $report->user_id }} reports:
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-end">
                                                            {{ $report->created_at }}
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
                                    <form id="dismissReportsForm" action="{{ route('remove.notification.reports', ['id' => $notification->id]) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="button" class="btn btn-danger deleteButton" data-button-type="dismissReports" data-toggle="modal" data-target="#delete-message" data-form-id="dismissReportsForm">Dismiss Reports</button>
                                    </form>
                                </div>
                            @else
                                <p>There are not reports</p>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                    <div class="container">
                        <div class="card ">
                            <div class="card-header ">
                                <h4 class="card-title">User #{{ $notification->user_id }} is a potential compulsive user</h4>
                            </div>
                            <div class="card-body">
                                @foreach ($reviews as $review)
                                    <div class="review">
                                        <div class="card ">
                                            <div class="card-header ">
                                                 <h5> <strong>User #{{ $review->user->id }} on
                                                    <a href="{{ url('admin/pages/show-review/') }}/{{ $review->id }}">review #{{ $review->id }}</a></strong>
                                                </h5>
                                                <p>           {{ $review->comment }}</p>
                                                <h5><strong>REPORTS:</strong></h5>
                                                    @foreach ($reports as $report)
                                                        @if($report->review_id == $review->id)
                                                        <p><strong>User #{{ $report->user_id }} reported:</strong></p>
                                                        <li>{{ $report->reason }}</li>
                                                        <form action="{{ route('reviews.dismiss_report', ['id' => $report->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger deleteButton" data-button-type="dismiss" data-toggle="modal" data-target="#dismiss-modal-{{ $report->id }}">Dismiss</button>
                                                        </form>
                                                        <hr>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="card-footer ">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="container">

                            <form id="dismissReportsForm" action="{{ route('remove.notification.reports', ['id' => $notification->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="button" data-button-type="delete" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="dismissReportsForm">Remove Notification and Reports</button>
                            </form>
                            <form id="dismissReportsStrikeForm" action="{{ route('remove.notification.reports.strike', ['id' => $notification->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="button" data-button-type="deleteStrike" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="dismissReportsStrikeForm">Add Strike</button>
                            </form>
                            <form id="removeNotificationForm" action="{{ route('remove.notification', ['id' => $notification->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" data-button-type="dismissNotification" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delete-message" data-form-id="removeNotificationForm">Remove Notification</button>
                            </form>
                    </div>
                @endif
                <div class="container">
                <a href="{{ url('/admin/pages/notifications') }}" class="btn btn-success">Go Back</a>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="delete-message" tabindex="-1" role="dialog" aria-labelledby="delete-message-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete-message-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="delete-message-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger deleteButtonModal" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    var formId = null;

                    $('.deleteButton').click(function () {
                        formId = $(this).data('form-id');
                        const buttonType = $(this).data('button-type');
                        if (buttonType === 'delete') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Attention!');
                            $('#delete-message-body').text('Are you sure you want to delete this notification and its reports? ');
                        } else if (buttonType === 'deleteStrike') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Add strike');
                            $('#delete-message-body').text('Are you sure you want to delete these reports, the notification and add a strike to the user?');
                        } else if (buttonType === 'dismissNotification') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Delete Notification');
                            $('#delete-message-body').text('Are you sure you want to delete this notification? These reports will continue being on the database');
                        } else if (buttonType === 'dismiss') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Dismiss');
                            $('#delete-message-body').text('Are you sure you want to dismiss this report?');
                        } else if (buttonType === 'deleteReview') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Delete the review');
                            $('#delete-message-body').text('Are you sure you want to delete this review?');
                        } else if (buttonType === 'deleteReviewStrike') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Delete this review');
                            $('#delete-message-body').text('Are you sure you want to delete this review and add a strike to the user?');
                        } else if (buttonType === 'dismissReports') {
                            console.log('Button type:', buttonType);
                            $('#delete-message-title').text('Dismiss Reports');
                            $('#delete-message-body').text('Are you sure you want to dismiss these reports?');
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

                    $('#delete-message').on('hidden.bs.modal', function () {
                        formId = null;
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
                                };
                                reader.readAsDataURL(files[i]);
                            }
                        });
                    });
                });
            </script>


@endsection
