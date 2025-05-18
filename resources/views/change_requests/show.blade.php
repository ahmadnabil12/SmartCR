@extends('layouts.admin')

@section('content')
<div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 40px; border-radius: 10px;">
    <h1 class="text-center text-dark mb-4">Change Request Details</h1>

    <!-- CR Details Card -->
    <div class="card shadow-sm" style="background-color: #ffffff; border-radius: 10px;">
        <div class="card-body">

            <!-- CR Title -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Title:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->title }}</p></div>
            </div>

            <!-- Unit -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Unit:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->unit }}</p></div>
            </div>

            <!-- Need By Date -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Need By Date:</strong></div>
                <div class="col-md-8">
                    <p>{{ \Carbon\Carbon::parse($changeRequest->need_by_date)->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Status -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Status:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->status }}</p></div>
            </div>

            <!-- Complexity -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Complexity:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->complexity ?? 'Not Assigned' }}</p></div>
            </div>

            <!-- Implementor -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Implementor:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->implementor->name ?? 'Not Assigned' }}</p></div>
            </div>

            <!-- Requestor -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Requestor:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->requestor->name ?? 'Unknown' }}</p></div>
            </div>

            <!-- Comment -->
            <div class="row mb-3">
                <div class="col-md-4"><strong>Comment:</strong></div>
                <div class="col-md-8"><p>{{ $changeRequest->comment ?? '-' }}</p></div>
            </div>

        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('change-requests.index') }}" class="btn btn-secondary ms-2"
            style="background-color: #6c757d; border-color: #5a6268;">Back to List</a>
    </div>
</div>
@endsection
