<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Top</h5>
            <h1 class="mb-5">Most Popular Restaurants</h1>
        </div>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                        <div class="ps-3">
                            <small class="text-body">Top</small>
                            <h6 class="mt-n1 mb-0">Rated</h6>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                        <div class="ps-3">
                            <small class="text-body">Top</small>
                            <h6 class="mt-n1 mb-0">Reviewed</h6>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach ($restaurants_rate as $restaurant)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $restaurant->main_image_url)}}" alt="{{ $restaurant->name }}" style="width: 80px;">
                                    </a>
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span>{{ $restaurant->name }}</span>
                                                <span>{{ $restaurant->price_range->range }}</span>
                                            </h5>
                                        </a>
                                        <small class="fst-italic">{{ $restaurant->address }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach ($restaurants_review as $restaurant)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $restaurant->main_image_url)}}" alt="{{ $restaurant->name }}" style="width: 80px;">
                                    </a>
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <a href="{{ route('restaurant', ['id' => $restaurant->id]) }}">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span >{{ $restaurant->name }}</span>
                                                <span>{{ $restaurant->price_range->range }}</span>
                                            </h5>
                                        </a>
                                        <small class="fst-italic">{{ $restaurant->address }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
