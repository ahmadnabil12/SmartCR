@extends('layouts.admin')

@section('content')

<div class="wow-card">
    <div class="wow-header">
        <i class="fas fa-user-plus"></i>
        <h2 style="color:#41acbc; font-weight: 800;">Create New User</h2>
        <p style="color: #338fa1;">Fill in user details below</p>
    </div>

    <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Jane Doe">
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="e.g. jane@email.com">
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="requestor">Requestor</option>
                <option value="implementor">Implementor</option>
                <option value="hou">Head of Unit (HOU)</option>
                <option value="hod">Head of Department (HOD)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Unit <span style="color:#bbb;">(for HOU only)</span></label>
            <select name="unit" id ="unit" class="form-select" disabled>
                <option value="">Select Unit</option>
                <option value="Delivery & Optimization (D&O)">Delivery & Optimization (D&O)</option>
                <option value="Logistics & Engineering (L&E)">Logistics & Engineering (L&E)</option>
                <option value="Human Resource & Back End (HR)">Human Resource & Back End (HR)</option>
                <option value="Finance">Finance</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Minimum 8 characters">
        </div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-wow"><i class="fas fa-plus-circle me-1"></i> Create User</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const unitSelect = document.getElementById('unit');

    function toggleUnitField() {
        if (roleSelect.value === 'hou') {
            unitSelect.disabled = false;
        } else {
            unitSelect.disabled = true;
            unitSelect.value = ""; // Optionally reset the field
        }
    }

    // Run on page load
    toggleUnitField();

    // Listen for changes
    roleSelect.addEventListener('change', toggleUnitField);
});
</script>

@endsection
