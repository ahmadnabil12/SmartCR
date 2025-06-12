@extends('layouts.admin')

@section('content')

<style>
    .teal-table th, .teal-table td { vertical-align: middle; }
    .btn-wow { background:#41acbc; border:none; color:#fff; border-radius:8px; }
    .btn-wow:hover { background:#338fa1; }
    .btn-edit { background:#ffc107; color:#333; border:none; border-radius:8px; }
    .btn-edit:hover { background:#e6a800; }
    .btn-delete { background:#e74c3c; color:#fff; border:none; border-radius:8px; }
    .btn-delete:hover { background:#b92d14; }

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
        background: #fff;
        box-shadow: none;
        outline: none;
        margin-left: 0;
        width: 100%;
        max-width: 550px;
        height: 2.5rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .dataTables_filter input[type="search"]:hover,
    .dataTables_filter input[type="search"]:focus {
        border-color: #41acbc;
        box-shadow: 0 2px 8px #41acbc11;
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
                    Users
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mt-1">
    <div class="card p-4" style="border-radius: 1.2rem; box-shadow:0 8px 40px rgba(65,172,188,0.13); border:2px solid #d4f3f8;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color:#41acbc;">List of Users</h3>
            <a href="{{ route('users.create') }}" class="btn btn-wow"><i class="fas fa-user-plus me-1"></i> Add User</a>
        </div>
    
        <table class="table table-hover table-striped teal-table" id="usersTable">
            <thead class="bg-teal text-white" style="background: #41acbc;">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('users.show', $user->id) }}" style="color:#41acbc;">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'hou') Head Of Unit (HOU)
                        @elseif($user->role == 'hod') Head Of Department (HOD)
                        @elseif($user->role == 'admin') Admin
                        @else {{ ucfirst($user->role) }}
                        @endif
                    </td>
                    <td>{{ $user->unit ?? '-' }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-wow btn-sm me-1"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit btn-sm me-1"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Delete this user?');"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($users->count() == 0)
                <tr>
                    <td colspan="6" class="text-center text-muted">No users found.</td>
                </tr>
                @endif
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
        $(document).ready(function () {
            $('#usersTable').DataTable({
                columnDefs: [
                    { searchable: true,  targets: 1 }, // Name column (assuming # is 0, Name is 1)
                    { searchable: false, targets: [0, 2, 3, 4, 5] } // #, Email, Role, Unit, Actions
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search users by name"
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
