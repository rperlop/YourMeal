@extends('admin.layouts.app', ['activePage' => 'dashboard', 'title' => 'Admin Panel', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class ="row">
                        <div class="col-sm-12">
                        <div class="card ">
                            <div class="card-header ">
                                <h4 class="card-title">{{ __('Top 5 Restaurants most reviewed') }}</h4>
                                <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                            </div>
                            <div class="card-body ">
                                <div class="chart-container">
                                    <canvas id="topRestaurantsChart"></canvas>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div>
                                    <form action="{{ url('/admin/update-featured-restaurant') }}" method="POST">
                                        @csrf
                                        <p>Click here to feature the most reviewed restaurant on last week</p>
                                        <button type="submit">Feature Restaurant</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class ="row">
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">{{ __('Total users') }}</h4>
                                    <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                                </div>
                                <div class="card-body ">
                                    <div class="chart-container">
                                        <canvas id="userCountChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">{{ __('Total restaurants') }}</h4>
                                    <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                                </div>
                                <div class="card-body ">
                                    <div class="chart-container">
                                        <canvas id="restaurantCountChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class ="row">
                        <div class="col-sm-12">
                        <div class="card  card-tasks">
                            <div class="card-header ">
                                <h4 class="card-title">{{ __('Notifications') }}</h4>
                                <p class="card-category">{{ __('Last 5') }}</p>
                            </div>
                            <div class="card-body ">
                                <div class="table-full-width">
                                    <table class="table">
                                        <tbody>
                                        @if (!$notifications->isEmpty())
                                            @foreach ($notifications->take(5) as $notification)
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        @if ($notification->type == 'compulsive_user')
                                                            <a href="{{ route('show-notification', ['id' => $notification->id]) }}">
                                                                {{ __('The user ') . $notification->user_id . __(' is a potential compulsive user.') }}
                                                            </a>
                                                            <i class="now-ui-icons loader_refresh spin"></i> {{ $notification->created_at }}

                                                        @else
                                                            <a href="{{ route('show-notification', ['id' => $notification->id]) }}">
                                                                {{ __('The review ') . $notification->review_id . __(' has been reported several times.') }}
                                                            </a>
                                                            <i class="now-ui-icons loader_refresh spin"></i> {{ $notification->created_at }}
                                                        @endif
                                                    </td>
                                                    <td class="td-actions text-right"></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td></td>
                                                <td>
                                                    There are not notifications.
                                                </td>
                                                <td class="td-actions text-right"></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const userCountCtx = document.getElementById('userCountChart').getContext('2d');
        const userCountChart = new Chart(userCountCtx, {
            type: 'bar',
            data: {
                labels: ['Users'],
                datasets: [{
                    label: 'Total',
                    data: [{{ $user_count }}],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        const restaurantCountCtx = document.getElementById('restaurantCountChart').getContext('2d');
        var restaurantCountChart = new Chart(restaurantCountCtx, {
            type: 'bar',
            data: {
                labels: ['Restaurants'],
                datasets: [{
                    label: 'Total',
                    data: [{{ $restaurant_count }}],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        const topRestaurantsData = @json($top_restaurants);

        const restaurantNames = topRestaurantsData.map(restaurant => restaurant.name);
        const reviewCounts = topRestaurantsData.map(restaurant => restaurant.reviews_count);

        const ctx = document.getElementById('topRestaurantsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: restaurantNames,
                datasets: [{
                    label: 'Total reviews',
                    data: reviewCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 2,
                    },
                    x: {
                        ticks: {

                            callback: function(value) {

                                return this.getLabelForValue(value).length > 10 ? this.getLabelForValue(value).substring(0,10) + "..." : this.getLabelForValue(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
