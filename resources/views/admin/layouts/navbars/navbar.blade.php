<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <span class="navbar-brand"> {{ $navName }} </span>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <span class="d-lg-none">{{ __('Dashboard') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav   d-flex align-items-center">
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }} <i class="nc-icon nc-button-power"></i></a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
