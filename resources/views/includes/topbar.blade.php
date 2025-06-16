<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

  <!-- Center Logos -->
  <div
    class="d-flex align-items-center"
    style="flex: 1; justify-content: center;"
  >
    <img
      src="{{ asset('img/uniten_logo.png') }}"
      alt="UNITEN Logo"
      style="height: 60px; margin: 0 1rem;"
    >
    <img
      src="{{ asset('img/ERP_Logo.gif') }}"
      alt="ERP Logo"
      style="height: 60px; margin: 0 1rem;"
    >
  </div>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) ->
    <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a>
        <!- Dropdown - Messages ->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li-->

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            @if(isset($unreadCount) && $unreadCount)
                <span class="badge badge-danger badge-counter">{{ $unreadCount > 3 ? '3+' : $unreadCount }}</span>
            @endif
        </a>
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown" style="min-width: 350px;">
            <div class="card-header text-white" style="background-color: #41acbc;">
                <strong>ALERTS CENTER</strong>
            </div>
            @forelse($notifications ?? [] as $note)
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle" style="background-color:#41acbc;">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $note->created_at->format('d M Y H:i') }}</div>
                        <span class="font-weight-bold">{{ $note->message }}</span>
                    </div>
                </a>
            @empty
                <div class="dropdown-item text-center small text-gray-500">No alerts</div>
            @endforelse
        </div>
    </li>

    <!-- Nav Item - Messages ->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" aria-expanded="false">

            <!- can click ->
        <!-a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"->
            
            <i class="fas fa-envelope fa-fw"></i>
            <!- Counter - Messages ->
            <span class="badge badge-danger badge-counter">7</span>
        </a>
        <!- Dropdown - Messages ->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">
                Message Center
            </h6>
            <!- Example message ->
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_1.svg"
                        alt="...">
                    <div class="status-indicator bg-success"></div>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                        problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                </div>
            </a>
            <!- Add more messages as needed ->
        </div>
    </li-->

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <div class="nav-item dropdown no-arrow">
        <!--a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            
                <-- Display the user's name on a separate line ->
                <div class="mr-2 d-none d-lg-inline text-gray-600 small" style="display:block;"> {{ Auth::user()->name }}</div>
                <-- Display the user's role (userCategory) below the name ->
                <div class="d-none d-lg-inline text-gray-400 small" style="font-size: 0.8em; color: #6c757d; display:block;"> {{ Auth::user()->userCategory }}
                </div>
        </a-->

        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle" src="/img/user.png" style="margin-right: 20px;">
                <span class="avatar avatar-sm" style="background-image: url(img/user.png"></span>
                <div class="d-none d-xl-block ps-2">
                    <div>{{ Auth::user()->name }}</div> <!-- Dynamically display the logged-in user's name -->
                    <div class="mt-1 small text-secondary">{{ auth()->user()->role_label }}</div> <!-- updated to use role -->
                </div>

            </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <!--a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Settings
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                Activity Log
            </a-->
            <div class="dropdown-divider"></div>
            <!-- Logout Button -->
            <a class="dropdown-item" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); 
                         document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
</div>

</ul>

</nav>
<!-- End of Topbar -->
