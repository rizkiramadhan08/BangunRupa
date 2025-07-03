<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon ms-2">
            <i class="fa fa-cogs"></i>
        </div>
        <div class="sidebar-brand-text ms-2 me-2">Administrator</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.list.desain') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.list.desain') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Desain</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.list.transaksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.list.transaksi') }}">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
