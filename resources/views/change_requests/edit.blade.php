@extends('layouts.admin')

@section('content')
<div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">
    <h1 class="text-center text-dark mb-4">Edit Change Request</h1>

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

    <form action="{{ route('change-requests.update', $changeRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title" class="form-label">CR Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $changeRequest->title }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" value="{{ $changeRequest->unit }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="need_by_date" class="form-label">Need By Date</label>
            <input type="date" class="form-control" id="need_by_date" name="need_by_date" value="{{ $changeRequest->need_by_date }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Requirement Gathering" {{ $changeRequest->status == 'Requirement Gathering' ? 'selected' : '' }}>Requirement Gathering</option>
                <option value="Feasibility Study" {{ $changeRequest->status == 'Feasibility Study' ? 'selected' : '' }}>Feasibility Study</option>
                <option value="SOW Preparation" {{ $changeRequest->status == 'SOW Preparation' ? 'selected' : '' }}>SOW Preparation</option>
                <option value="Development" {{ $changeRequest->status == 'Development' ? 'selected' : '' }}>Development</option>
                <option value="UAT" {{ $changeRequest->status == 'UAT' ? 'selected' : '' }}>UAT</option>
                <option value="Deployment" {{ $changeRequest->status == 'Deployment' ? 'selected' : '' }}>Deployment</option>
                <option value="Completed" {{ $changeRequest->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="complexity" class="form-label">Complexity</label>
            <select class="form-control" id="complexity" name="complexity" required>
                <option value="Low" {{ $changeRequest->complexity == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $changeRequest->complexity == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $changeRequest->complexity == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ $changeRequest->comment }}</textarea>
        </div>

        <button type="submit" class="btn btn-success" style="background-color: #28a745; border-color: #218838;">Update Change Request</button>
        <a href="{{ route('change-requests.index') }}" class="btn btn-secondary btn-md ms-2" style="background-color: #6c757d; border-color: #5a6268;">Cancel</a>
    </form>
</div>
@endsection

