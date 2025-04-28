@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">
        <h1 class="text-center text-dark mb-4">Create New Academician</h1>

        <form action="{{ route('academicians.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label for="staff_number" class="form-label">Staff Number</label>
                <input type="text" class="form-control" id="staff_number" name="staff_number" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label for="college" class="form-label">College</label>
                <select name="college" id="college" class="form-control" required>
                    <option value="" disabled selected>Select College</option>
                    <option value="College of Computing & Informatics (CCI)">College of Computing & Informatics (CCI)</option>
                    <option value="College of Engineering (COE)">College of Engineering (COE)</option>
                    <option value="UNITEN Business School (UBS)">UNITEN Business School (UBS)</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department" id="department" class="form-control" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="Department of Computing">Department of Computing</option>
                    <option value="Department of Informatics">Department of Informatics</option>
                    <option value="Department of Foundation and Diploma Studies">Department of Foundation and Diploma Studies</option>
                    <option value="Department of Electrical & Electronics Engineering">Department of Electrical & Electronics Engineering</option>
                    <option value="Department of Mechanical Engineering">Department of Mechanical Engineering</option>
                    <option value="Department of Civil Engineering">Department of Civil Engineering</option>
                    <option value="Department of Accounting and Economic">Department of Accounting and Economic</option>
                    <option value="Department of Management">Department of Management</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="position" class="form-label">Position</label>
                <select name="position" id="position" class="form-control" required>
                    <option value="" disabled selected>Select Position</option>
                    <option value="Professor">Professor</option>
                    <option value="Assoc. Prof.">Assoc. Prof.</option>
                    <option value="Senior Lecturer">Senior Lecturer</option>
                    <option value="Lecturer">Lecturer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Save Academician</button>
            <a href="{{ route('academicians.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
