<aside class="main-sidebar sidebar-light-primary elevation-4" id="sidebar">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <img src="{{ asset('logo.png') }}"  style="margin-right:50px"  id="lebar" style="opacity: .8;" id="logo-admin">
            <img src="{{ asset('logo2.png') }}" id="kecil" style="opacity: .8;" id="logo-admin">

        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <img src="{{ asset("icon/icon-dashboard.png") }}" />
                        <p>
                            Main Dashboard
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                  <a href="#" class="nav-link ">
                  <img src="{{ asset("icon/icon-devices.png") }}" width="30px">
                    <p>
                      Device
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('switch.index') }}" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Switch</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('firewall.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Firewall</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('server.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Server</p>
                      </a>
                    </li>
                  </ul>
                </li>

                @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <img src= "{{asset ("icon/icon-manage-users.png") }}" width="30px">
                    <p>
                      Managed Users
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('admin.user.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Users</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.admin.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Admin</p>
                      </a>
                    </li>
                  </ul>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
