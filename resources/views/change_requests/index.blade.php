@extends('layouts.admin')

@section('content')
@php
    $user = Auth::user();
@endphp

<style>
    .teal-table th, .teal-table td { vertical-align: middle; }
    .btn-wow { background:#41acbc; border:none; color:#fff; border-radius:8px; }
    .btn-wow:hover { background:#338fa1; }
    .btn-edit { background:#ffc107; color:#333; border:none; border-radius:8px; }
    .btn-edit:hover { background:#e6a800; }
    .btn-delete { background:#e74c3c; color:#fff; border:none; border-radius:8px; }
    .btn-delete:hover { background:#b92d14; }

    /* 1) Pill wrapper */
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

    /* 2) Remove inner borders/shadows on the input */
    .search-bar__input {
    border: none !important;
    box-shadow: none !important;
    }

    /* 3) Style the search button cleanly */
    .search-bar__btn {
    border: none !important;
    background: transparent !important;
    color: #666;
    padding: 0 16px;
    }

    /* 4) Subtle hover effect */
    .search-bar__btn:hover {
    background: rgba(0, 0, 0, 0.05);
    }
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

    <!-- Search Bar -->
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
    </form>

    <table class="table table-hover table-striped teal-table">
      <thead style="background: #41acbc;" class="text-white">
        <tr>
          <th>Title</th>
          <th>Unit</th>
          <th>Need By</th>
          @if (in_array($user->role, ['implementor','hou','hod','admin']))
            <th>Status</th>
            <th>Complexity</th>
          @endif
          <th>Implementor</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($changeRequests as $cr)
        <tr>
          <td>{{ $cr->title }}</td>
          <td>{{ $cr->unit }}</td>
          <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M, Y') }}</td>

          @if($user->role !== 'requestor')
            <td>{{ $cr->status }}</td>
            <td>{{ $cr->complexity ?? 'N/A' }}</td>
          @endif

          <td>{{ $cr->implementor->name ?? 'Not Assigned' }}</td>
          <td class="d-flex align-items-center gap-2">
            <a href="{{ route('change-requests.show',   $cr->id) }}" class="btn btn-wow btn-sm" style="margin-right: 5px;"><i class="fas fa-eye"></i></a>
            <a href="{{ route('change-requests.edit',   $cr->id) }}" class="btn btn-edit btn-sm" style="margin-right: 5px;"><i class="fas fa-edit"></i></a>
            <form action="{{ route('change-requests.destroy', $cr->id) }}"
                  method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit"
                      class="btn btn-delete btn-sm me-1"
                      onclick="return confirm('Delete this CR?');">
                <i class="fas fa-trash"></i>
              </button>
            </form>
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
