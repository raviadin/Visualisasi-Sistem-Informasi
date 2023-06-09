<nav class="main-header navbar navbar-expand navbar-primary navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" onclick="toggleImage()">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <span href="#" class="nav-link">@yield('title')</span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">


                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="img-circle elevation-2" alt="User Image"
                    style="width: 35px; margin-top:-10px;">

                <span>{{ Auth::user()->name }} </span>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('profile') }}" class="dropdown-item">
                <i class="fas fa-user"></i>  Profile
                </a>
            <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i
                        class="fas fa-sign-out-alt"></i>
                    <span> Logout</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>

            </div>
        </li>
        <li class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </li>
    </ul>
</nav>
