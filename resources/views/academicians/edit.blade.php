@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">
        <h1 class="text-center text-dark mb-4">Edit Academician</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; border-color: #c82333; color: white;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('academicians.update', $academician->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $academician->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="staff_number" class="form-label">Staff Number</label>
                <input type="text" class="form-control" id="staff_number" name="staff_number" value="{{ $academician->staff_number }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $academician->email }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="college" class="form-label">College</label>
                <select name="college" id="college" class="form-control" required>
                    <option value="College of Computing & Informatics (CCI)" {{ $academician->college == 'College of Computing & Informatics (CCI)' ? 'selected' : '' }}>College of Computing & Informatics (CCI)</option>
                    <option value="College of Engineering (COE)" {{ $academician->college == 'College of Engineering (COE)' ? 'selected' : '' }}>College of Engineering (COE)</option>
                    <option value="UNITEN Business School (UBS)" {{ $academician->college == 'UNITEN Business School (UBS)' ? 'selected' : '' }}>UNITEN Business School (UBS)</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department" id="department" class="form-control" required>
                    <option value="Department of Computing" {{ $academician->department == 'Department of Computing' ? 'selected' : '' }}>Department of Computing</option>
                    <option value="Department of Informatics" {{ $academician->department == 'Department of Informatics' ? 'selected' : '' }}>Department of Informatics</option>
                    <option value="Department of Civil Engineering" {{ $academician->department == 'Department of Civil Engineering' ? 'selected' : '' }}>Department of Civil Engineering</option>
                    <!-- Add other departments as needed -->
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="position" class="form-label">Position</label>
                <select name="position" id="position" class="form-control" required>
                    <option value="Professor" {{ $academician->position == 'Professor' ? 'selected' : '' }}>Professor</option>
                    <option value="Assoc. Prof." {{ $academician->position == 'Assoc. Prof.' ? 'selected' : '' }}>Assoc. Prof.</option>
                    <option value="Senior Lecturer" {{ $academician->position == 'Senior Lecturer' ? 'selected' : '' }}>Senior Lecturer</option>
                    <option value="Lecturer" {{ $academician->position == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success" style="background-color: #28a745; border-color: #218838;">Update Academician</button>
            <a href="{{ route('academicians.index') }}" class="btn btn-secondary ms-2" style="background-color: #6c757d; border-color: #5a6268;">Cancel</a>
        </form>
    </div>
@endsection
