@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 40px; border-radius: 10px;">
        <h1 class="text-center text-dark mb-4">Academician Details</h1>

        <!-- Academician Details Card -->
        <div class="card shadow-sm" style="background-color: #ffffff; border-radius: 10px;">
            <div class="card-body">
                <h3 class="card-title text-center text-primary mb-4"></h3>

                <!-- Name -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Name:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->name }}</p>
                    </div>
                </div>

                <!-- Staff Number -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Staff Number:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->staff_number }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->email }}</p>
                    </div>
                </div>

                <!-- College -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>College:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->college }}</p>
                    </div>
                </div>

                <!-- Department -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Department:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->department }}</p>
                    </div>
                </div>

                <!-- Position -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Position:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $academician->position }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('academicians.index') }}" class="btn btn-secondary ms-2" style="background-color: #6c757d; border-color: #5a6268;">Back to List</a>
        </div>
    </div>
@endsection
