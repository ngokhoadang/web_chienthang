<header class="main-header">
    <a href="{{ url('/admin/index') }}" class="logo">
        <span class="logo-mini"><b>@yield('app.shortname', 'MT')</b>cp</span>
        <span class="logo-lg"><b>@yield('app.name', 'CONTROL')</b>cp</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">BUTTON</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
                        <span class="hidden-xs">{{ Auth::user()->full_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            {{-- <img src="#" class="img-circle" style="display:none" alt="User Image"> --}}
                            <p>User name <small>Member since Nov. 2012</small></p>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </nav>
</header>