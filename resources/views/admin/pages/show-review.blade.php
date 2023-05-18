@extends('admin.layouts.app', ['activePage' => 'reviews', 'title' => 'Admin - Show review', 'navName' => 'Show review'])

@section('content')

    <div class="container-xxl bg-white p-0">
        <div class="container">

            <div class="row g-5 align-items-center">
                <div class="container container px-5 pt-3">
                    <div class="row justify-content-between mb-3">
                        <div class="col-auto align-self-center">
                            <h2>Review</h2>
                        </div>
                    </div>
                    <div class="review-block">
                        <div class="row service-item p-3 mb-4">
                            <div class="col-sm-2">
                                <div class="review-block-date mb-4">User #{{ $review->user_id }} reviewed:
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    Restaurant #{{ $review->restaurant_id }}
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
                </div>
                    <form action="{{ route('reviews.delete', ['id' => $review->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete Review</button>
                    </form>
                    <form action="{{ route('reviews.delete_with_strike', ['id' => $review->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this review and apply a strike to the user?')">Delete Review with Strike</button>
                    </form>
            </div>
            @if ($review->reports->count() > 0)
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="container container px-5 pt-3">
                        <div class="row justify-content-between mb-3">
                            <div class="col-auto align-self-center">
                                <h2>Reports</h2>
                            </div>
                        </div>
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
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('reviews.dismiss_reports', ['id' => $review->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Dismiss Reports</button>
                </form>
            @endif

                <a href="{{ url('/admin/pages/index-reviews') }}" class="btn btn-success">Go Back</a>



            </div>
        <script>

            $(document).ready(function () {
                $('.rating-form').rating();
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
