@extends('admin.layouts.app', ['activePage' => 'dashboard', 'title' => 'Admin Panel', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('2017 Sales') }}</h4>
                            <p class="card-category">{{ __('All products including Taxes') }}</p>
                        </div>
                        <div class="card-body ">
                            <div id="chartActivity" class="ct-chart"></div>
                        </div>
                        <div class="card-footer ">
                            <div class="legend">
                                <i class="fa fa-circle text-info"></i> {{ __('Tesla Model S') }}
                                <i class="fa fa-circle text-danger"></i> {{ __('BMW 5 Series') }}
                            </div>
                            <hr>
                            <div class="stats">
                                <i class="fa fa-check"></i> {{ __('Data information certified') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Tasks') }}</h4>
                            <p class="card-category">{{ __('Backend development') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="table-full-width">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Sign contract for "What are conference organizers afraid of?"') }}</td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="" checked>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Lines From Great Russian Literature? Or E-mails From My Boss?') }}</td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="" checked>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit') }}
                                        </td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Create 4 Invisible User Experiences you Never Knew About') }}</td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Read "Following makes Medium better"') }}</td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="" disabled>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ __('Unfollow 5 enemies from twitter') }}</td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-link">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-link">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="now-ui-icons loader_refresh spin"></i> {{ __('Updated 3 minutes ago') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Total users') }}</h4>
                            <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                        </div>
                        <div class="card-body ">
                        <canvas id="userCountChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Total restaurants') }}</h4>
                            <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                        </div>
                        <div class="card-body ">
                            <canvas id="restaurantCountChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Top 5 Restaurants most reviewed') }}</h4>
                            <p class="card-category">{{ __('Since YourMeal was created') }}</p>
                        </div>
                        <div class="card-body ">
                            <div>
                                <canvas id="topRestaurantsChart"></canvas>
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
                data: [{{ $userCount }}],
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
    const restaurantCountChart = new Chart(restaurantCountCtx, {
        type: 'bar',
        data: {
            labels: ['Restaurants'],
            datasets: [{
                label: 'Total',
                data: [{{ $restaurantCount }}],
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

    const topRestaurantsData = @json($topRestaurants);

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
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 2,
                }
            }
        }
    });
</script>
@endpush
