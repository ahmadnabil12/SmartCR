@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 40px; border-radius: 10px;">
        <h1 class="text-center text-dark mb-4">Milestone Details</h1>

        <!-- Milestone Details Card -->
        <div class="card shadow-sm" style="background-color: #ffffff; border-radius: 10px;">
            <div class="card-body">
                <h3 class="card-title text-center text-primary mb-4"></h3>

                <!-- Milestone Title -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Milestone Title:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $milestone->milestone_title }}</p>
                    </div>
                </div>

                <!-- Associated Grant -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Grant Associated:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $milestone->grant->project_title }}</p>
                    </div>
                </div>

                <!-- Completion Date -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Completion Date:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ \Carbon\Carbon::parse($milestone->completion_date)->format('d M, Y') }}</p>
                    </div>
                </div>

                <!-- Deliverable -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Deliverable:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $milestone->deliverable }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $milestone->status }}</p>
                    </div>
                </div>

                <!-- Remark -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Remark:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $milestone->remark }}</p>
                    </div>
                </div>

                <!-- Date Updated -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Date Updated:</strong>
                    </div>
                    <div class="col-md-8">
                        <p>{{ \Carbon\Carbon::parse($milestone->updated_at)->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('milestones.index') }}" class="btn btn-secondary ms-2" style="background-color: #6c757d; border-color: #5a6268;">Back to List</a>
        </div>
    </div>
@endsection
