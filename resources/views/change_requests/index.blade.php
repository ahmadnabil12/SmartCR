@extends('layouts.admin')

@section('content')
@php
    $user = Auth::user();
@endphp

@if(session('success'))
    <div id="flash-message" class="alert alert-success" style="
        position: fixed;
        top: 30px;
        right: 40px;
        z-index: 9999;
        min-width: 220px;
        background: #41acbc;
        color: #fff;
        border-radius: 6px;
        padding: 14px 28px;
        box-shadow: 0 2px 16px #41acbc33;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    ">
        <i class="fas fa-check-circle" style="font-size:1.3em"></i>
        {{ session('success') }}
    </div>
@endif

<style>
    .teal-table th, .teal-table td { vertical-align: middle; }
    .btn-wow { background:#41acbc; border:none; color:#fff; border-radius:8px; }
    .btn-wow:hover { background:#338fa1; }
    .btn-edit { background:#ffc107; color:#333; border:none; border-radius:8px; }
    .btn-edit:hover { background:#e6a800; }
    .btn-delete { background:#e74c3c; color:#fff; border:none; border-radius:8px; }
    .btn-delete:hover { background:#b92d14; }

    /* 1) Pill wrapper 
    .search-bar {
      display: inline-flex;
      align-items: center;
      width: 100%;
      max-width: 600px;
      margin: 0 auto 1rem;
      border: 1px solid #ccc;
      border-radius: 999px;
      overflow: hidden;
      background: #fff;
    }

    /* 2) Remove inner borders/shadows on the input 
    .search-bar__input {
    border: none !important;
    box-shadow: none !important;
    }

    /* 3) Style the search button cleanly 
    .search-bar__btn {
    border: none !important;
    background: transparent !important;
    color: #666;
    padding: 0 16px;
    }

    /* 4) Subtle hover effect 
    .search-bar__btn:hover {
    background: rgba(0, 0, 0, 0.05);
    }*/

    /* DataTables pill-shaped search bar with teal hover */
    .dataTables_filter label {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }

    .dataTables_filter input[type="search"] {
        border-radius: 999px;
        border: 1.5px solid #ccc;
        padding: 0.32rem 1.1rem;
        font-size: 1rem;
        color: #666;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
        box-shadow: none;
        outline: none;
        margin-left: 0;
        width: 100%;
        max-width: 550px;
        height: 2.5rem;
    }

    .dataTables_filter input[type="search"]:hover,
    .dataTables_filter input[type="search"]:focus {
        border-color: #41acbc;
        box-shadow: 0 2px 8px #41acbc11;
    }

    /* Status color coding */
    .delayed-date   { background: #ff4d4f;  color: #fff; font-weight:600; border-radius:6px; padding:3px 10px;}
    .urgent-date    { background: #ff6e00;  color: #fff; font-weight:600; border-radius:6px; padding:3px 10px; }
    .important-date { background: #ffd700;  color: #333; font-weight:600; border-radius:6px; padding:3px 10px;}
    .standard-date  { background: #52c41a;  color: #fff; font-weight:600; border-radius:6px; padding:3px 10px;}
    

      
</style>

<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('welcome') }}" style="color: #41acbc; font-weight: 500;">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" style="color: #41acbc; font-weight: 500;">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #888;">
                    Change Requests
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mt-1">
  <div class="card p-4"
       style="border-radius: 1.2rem;
              box-shadow: 0 8px 40px rgba(65,172,188,0.13);
              border: 2px solid #d4f3f8;">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold" style="color: #41acbc;">List of Change Requests</h3>

      <!-- Submit New CR button only for requestors -->
      @if ($user->role === 'requestor')
        <a href="{{ route('change-requests.create') }}"
           class="btn btn-wow">
          <i class="fas fa-plus me-1"></i> Submit New CR
        </a>
      @endif
    </div>

    <!-- Search Bar >
    <form action="{{ route('change-requests.index') }}" method="GET" class="mb-4">
        <div class="input-group search-bar">
            <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Search users by CR Title…"
            >
            <div class="input-group-append">
            <button class="btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>
    </form-->

    <table class="table table-hover table-striped teal-table" id="changeRequestsTable">
      <thead style="background: #41acbc;" class="text-white">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Unit</th>
          <th>Need By</th>
          <th>Status</th>
          <th>Implementor</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <!-- Define the order of statuses for sorting -->
        @php
            $statusOrder = [
                'Requirement Gathering'   => 1,
                'Feasibility Study'       => 2,
                'SOW Preparation'         => 3,
                'SOW Sign Off'            => 4,
                'Quotation Preparation'   => 5,
                'Quotation Sign Off'      => 6,
                'Development Plan'        => 7,
                'Development'             => 8,
                'SIT'                     => 9,
                'UAT'                     => 10,
                'UAT Sign Off'            => 11,
                'Deployment'              => 12,
            ];
        @endphp

        @forelse($changeRequests as $cr)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $cr->title }}</td>
          <td>{{ $cr->unit }}</td>

          <!-- Display urgency based on need_by_date -->
          @php
              $today = \Carbon\Carbon::today();
              $needBy = \Carbon\Carbon::parse($cr->need_by_date);
              $diff = $today->diffInDays($needBy, false); // false = negative if past
              if ($diff < 0) {
                  // Delayed
                  $bg = '#ff4d4f'; // Dark Red
                  $label = 'Delayed';
              } elseif ($diff <= 10) {
                  // Urgent
                  $bg = '#ff6e00'; // Red
                  $label = 'Urgent';
              } elseif ($diff <= 20) {
                  // Important
                  $bg = '#ffd700'; // Yellow
                  $label = 'Important';
              } else {
                  // Standard
                  $bg = '#52c41a'; // Green
                  $label = 'Standard';
              }
          @endphp
          <td data-order="{{ $cr->need_by_date }}">
              <div style="background: {{ $bg }};
                          color: {{ $bg == '#ffeb3b' ? '#333':'#fff' }};
                          font-weight: 600;
                          border-radius: 4px;
                          padding: 8px 0;
                          width: 100%;
                          text-align: center;
                          white-space: nowrap;">
                  {{ $needBy->format('d M Y') }}
              </div>
          </td>

          <!-- Status column only for non-requestors -->
          @php
              $statusIndex = $statusOrder[$cr->status ?? ''] ?? 99;
          @endphp
          <td data-order="{{ $statusIndex }}">
              {{ $cr->status }}
          </td>

          <!-- Implementor name column -->
          <td>{{ $cr->implementor->name ?? 'Not Assigned' }}</td>

            <!-- Actions column in your table -->
            <td>
                <!-- Wrap buttons in a flex container for horizontal alignment -->
                <div class="d-flex align-items-center" style="gap: 4px;">
                    <!-- Requestor: Edit/Delete only if Requirement Gathering -->
                    @if(auth()->user()->role === 'requestor')
                        @if($cr->status == 'Requirement Gathering')
                            <!-- Edit button for Requestor -->
                            <a href="{{ route('change-requests.edit', $cr->id) }}"
                              class="btn btn-edit btn-sm me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Delete button for Requestor -->
                            <form action="{{ route('change-requests.destroy', $cr->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-sm me-1"
                                        onclick="return confirm('Delete this CR?');"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                        <!-- View button for Requestor -->
                        <a href="{{ route('change-requests.show', $cr->id) }}"
                          class="btn btn-wow btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    <!-- Admin: Always can edit/delete -->
                    @elseif(auth()->user()->role === 'admin')
                        <!-- Edit button for Admin -->
                        <a href="{{ route('change-requests.edit', $cr->id) }}"
                          class="btn btn-edit btn-sm me-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <!-- Delete button for Admin -->
                        <form action="{{ route('change-requests.destroy', $cr->id) }}"
                              method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete btn-sm me-1"
                                    onclick="return confirm('Delete this CR?');"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <!-- View button for Admin -->
                        <a href="{{ route('change-requests.show', $cr->id) }}"
                          class="btn btn-wow btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    <!-- Implementor: Can edit if assigned -->
                    @elseif(auth()->user()->role === 'implementor' && $cr->implementor_id == auth()->user()->id)
                        <!-- Edit button for Implementor -->
                        <a href="{{ route('change-requests.edit', $cr->id) }}"
                          class="btn btn-edit btn-sm me-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <!-- View button for Implementor -->
                        <a href="{{ route('change-requests.show', $cr->id) }}"
                          class="btn btn-wow btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    @else
                        <!-- View button for HOU, HOD, etc. -->
                        <a href="{{ route('change-requests.show', $cr->id) }}"
                          class="btn btn-wow btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
          <td colspan="{{ in_array($user->role,['implementor','hou','hod','admin']) ? 7 : 5 }}"
              class="text-center text-muted">
            No change requests available.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      setTimeout(() => {
          const msg = document.getElementById('flash-message');
          if(msg) msg.style.display = 'none';
      }, 5000);

        $(document).ready(function () {
            $('#changeRequestsTable').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": -1 }
                ],
                "language": {
                    search: "",
                    searchPlaceholder: "Search CR by title"
                }
            });

            // Move DataTables search bar to be wider and more centered if needed
            $('.dataTables_filter input[type="search"]').css({
                'width': '100%',
                'max-width': '700px'
            });
        });
    </script>
@endpush

