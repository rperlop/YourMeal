<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" sizes="76x76" href="assets/img/icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - YourMeal</title>

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/9872be4a49.js" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{asset('favicon.ico')}}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
    <link href="{{asset('lib/lightbox/css/lightbox.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-bowl-food me-3"></i>YourMeal</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                @auth
                    <a href="{{ url('/recommendations') }}" class="nav-item nav-link">Recommendations</a>
                @endauth
                <a href="#" class="nav-item nav-link">Search</a>
                @guest
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    <a href="{{ url('/registers') }}" class="nav-item nav-link">Register</a>
                @else
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->first_name }}</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ url('/user-data') }}" class="dropdown-item">User data</a>
                            <a href="{{ url('/user-preferences') }}" class="dropdown-item">Food preferences</a>
                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <li><a href="{{ url('/admin/dashboard') }}" class="dropdown-item">Admin dashboard</a></li>
                            @endif
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</div>

<!-- Page Content -->
<main>
    @yield('content')
</main>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">YourMeal</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="mailto:info@yourmeal.com">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Attention!</h5>
            </div>
            @auth
            @if(Auth::user()->strikes == \App\Models\Config::where('property', 'strikes_number')->value('value'))
            <div class="modal-body">
                We regret to inform you that you have been banned for continuously and repeatedly violating our rules. Your user will be deleted. <br><br>Please, confirm you have been notified.
            </div>
            @else
                <div class="modal-body">
                    You have received a strike for violating our rules. Moderate your behaviour and be responsible with your
                    use of our site. If you continue to do so, you will be banned. <br><br>Please, confirm you have been notified.
                </div>
            @endif
            @endauth
            <div class="modal-footer">
                <form method="POST" action="{{ route('disable-notification') }}" id="disable-notification-form">
                    @csrf
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (Auth::check() && Auth::user()->notify == 1)
    <script>
        $(document).ready(function() {
            $('#exampleModalCenter').modal('show');
        });
    </script>
@endif

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('lib/wow/wow.min.js')}}"></script>
<script src="{{asset('lib/easing/easing.min.js')}}"></script>
<script src="{{asset('lib/lightbox/js/lightbox.js')}}"></script>
<script src="{{asset('lib/easing/easing.min.js')}}"></script>
<script src="{{asset('lib/simple-rating/simple-rating.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('js/main.js')}}"></script>
</body>
</html>
