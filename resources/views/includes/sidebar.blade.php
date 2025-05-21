<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('welcome') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SmartCR</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Change Requests -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCR"
           aria-expanded="false" aria-controls="collapseCR">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Change Requests</span>
        </a>
        <div id="collapseCR" class="collapse" aria-labelledby="headingCR" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">CR Management</h6>
                <a class="collapse-item" href="{{ route('change-requests.index') }}">All CRs</a>
                <a class="collapse-item" href="{{ route('change-requests.pending') }}">Pending CRs</a>
                <a class="collapse-item" href="{{ route('change-requests.completed') }}">Completed CRs</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
