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
</style>

<div class="container mt-5">
    <div class="card p-4" style="border-radius: 1.2rem; box-shadow:0 8px 40px rgba(65,172,188,0.13); border:2px solid #d4f3f8;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color:#41acbc;">User Management</h3>
            <a href="{{ route('users.create') }}" class="btn btn-wow"><i class="fas fa-user-plus me-1"></i> Add User</a>
        </div>
        <table class="table table-hover table-striped">
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
                    <td>{{ $i+1 }}</td>
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
