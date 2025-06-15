<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:rgb(65, 172, 188);">

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
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
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
    <li class="nav-item {{ request()->routeIs('change-requests.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCR"
           aria-expanded="false" aria-controls="collapseCR">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Change Requests</span>
        </a>
        <div id="collapseCR" class="collapse {{ request()->routeIs('change-requests.*') ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">CR Management</h6>
                <a class="collapse-item" href="{{ route('change-requests.index') }}">All CRs</a>
                <a class="collapse-item" href="{{ route('change-requests.pending') }}">Pending CRs</a>
                <a class="collapse-item" href="{{ route('change-requests.completed') }}">Completed CRs</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Users -->
    @if(auth()->user()->role === 'admin')
        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" 
                data-toggle="collapse" data-target="#collapseUsers" 
                aria-expanded="false" aria-controls="collapseUsers">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}">
                <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">By Role:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">
                    All Users
                </a>
                <a class="collapse-item" href="{{ route('users.index', ['role'=>'requestor']) }}">
                    Requestor
                </a>
                <a class="collapse-item" href="{{ route('users.index', ['role'=>'implementor']) }}">
                    Implementor
                </a>
                <a class="collapse-item" href="{{ route('users.index', ['role'=>'hou']) }}">
                    HOU
                </a>
                <a class="collapse-item" href="{{ route('users.index', ['role'=>'hod']) }}">
                    HOD
                </a>
                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Reports -->
    @if(auth()->user()->role === 'admin'|| auth()->user()->role === 'hod' || auth()->user()->role === 'hou')
        <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reports.index') }}">
                <i class="fas fa-chart-bar me-2"></i>
                <span>Reports</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
