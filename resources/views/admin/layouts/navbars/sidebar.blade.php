<div class="sidebar" data-color="black">
    <div class="sidebar-wrapper" >
        <div class="logo">
            <a href="{{ url('/admin/dashboard') }}" class="simple-text">
                {{ __("YourMeal Admin") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'user-management') active @endif">
                <a class="nav-link" href="{{url('/admin/pages/index-users')}}">
                    <i class="nc-icon nc-circle-09"></i>
                    <p>{{ __("User Management") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'reviews') active @endif">
                <a class="nav-link" href="{{url('/admin/pages/index-reviews')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Reviews") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'restaurants') active @endif">
                <a class="nav-link" href="{{url('/admin/pages/index-restaurants')}}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Restaurants") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'admin-policy') active @endif">
                <a class="nav-link" href="{{url('/admin/pages/admin-policy')}}">
                    <i class="nc-icon nc-settings-gear-64"></i>
                    <p>{{ __("Admin Policy") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'notifications') active @endif">
                <a class="nav-link" href="{{url('/admin/pages/notifications')}}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Notifications") }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/')}}">
                    <i class="nc-icon nc-tap-01"></i>
                    <p>{{ __("YourMeal web") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
