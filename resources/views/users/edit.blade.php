@extends('layouts.admin')

@section('content')

<div class="wow-card">
    <div class="wow-header">
        <i class="fas fa-user-edit"></i>
        <h2 style="color:#41acbc; font-weight: 800;">Edit User</h2>
        <p style="color: #338fa1;">Update user details below</p>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="requestor" {{ $user->role == 'requestor' ? 'selected' : '' }}>Requestor</option>
                <option value="implementor" {{ $user->role == 'implementor' ? 'selected' : '' }}>Implementor</option>
                <option value="hou" {{ $user->role == 'hou' ? 'selected' : '' }}>Head of Unit (HOU)</option>
                <option value="hod" {{ $user->role == 'hod' ? 'selected' : '' }}>Head of Department (HOD)</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Unit <span style="color:#bbb;">(for HOU only)</span></label>
            <input type="text" name="unit" class="form-control" value="{{ $user->unit }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Change Password</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
        </div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-wow"><i class="fas fa-save me-1"></i> Update User</button>
        </div>
    </form>
</div>
@endsection
