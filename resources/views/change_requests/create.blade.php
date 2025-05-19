@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">
        <h1 class="text-center text-dark mb-4">Submit New Change Request</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('change-requests.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="title" class="form-label">CR Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="unit" class="form-label">Unit</label>
                <select class="form-control" id="unit" name="unit" required>
                    <option value="">-- Select Unit --</option>
                    <option value="Logistics and Engineering (L&E)">Logistics and Engineering (L&E)</option>
                    <option value="Delivery & Optimization (D&O)">Delivery & Optimization (D&O)</option>
                    <option value="Finance">Finance</option>
                    <option value="Human Resource & Back End (HR)">Human Resource & Back End (HR)</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="need_by_date" class="form-label">Need By Date</label>
                <input type="date" class="form-control" id="need_by_date" name="need_by_date" required>
            </div>

            <div class="form-group mb-3">
                <label for="implementor_id" class="form-label">Assign to Implementor</label>
                <select class="form-control" id="implementor_id" name="implementor_id" required>
                    <option value="">Select Implementor</option>
                    @foreach($implementors as $implementor)
                        <option value="{{ $implementor->id }}">{{ $implementor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success btn-md" style="background-color: #28a745; border-color: #218838;">Submit CR</button>
            <a href="{{ route('change-requests.index') }}" class="btn btn-secondary btn-md ms-2">Cancel</a>
        </form>
    </div>
@endsection
