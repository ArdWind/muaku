<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('/asset/cust/icolight.png') }}" alt="MUA.KU Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">MUA.KU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
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
                @if (in_array(auth()->user()->role, ['admin', 'staff']))
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('data*') ? 'menu-open' : '' }}">
                        <a href="javascript:void(0);" class="nav-link {{ request()->is('data*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                @endif
                <ul class="nav nav-treeview">
                    @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a href="/data-users" class="nav-link {{ request()->is('data-users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/data-products"
                                class="nav-link {{ request()->is('data-products*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Data Produk</p>
                            </a>
                        </li>
                    @elseif (auth()->user()->role == 'staff')
                        <li class="nav-item">
                            <a href="/data-galeries"
                                class="nav-link {{ request()->is('data-galeries*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-image"></i>
                                <p>Galery</p>
                            </a>
                        </li>
                    @endif
                </ul>
                </li>
                @if (auth()->user()->role == 'customer')
                    <li class="nav-item">
                        <a href="/detail/wedding"
                            class="nav-link {{ request()->is('/detail/wedding*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-image"></i>
                            <p>Detail</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="/logout" class="nav-link">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
