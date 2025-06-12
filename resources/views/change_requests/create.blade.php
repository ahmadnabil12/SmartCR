@extends('layouts.admin')

@section('content')

<div class="wow-card">
    <div class="wow-header">
        <i class="fas fa-file-alt"></i>
        <h2 style="color:#41acbc; font-weight: 800;">Submit New Change Request</h2>
        <p style="color: #338fa1;">Fill in request details below</p>
    </div>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('change-requests.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">CR Title</label>
            <input 
                type="text" 
                name="title" 
                id="title"
                class="form-control" 
                value="{{ old('title') }}"
                required
                placeholder="Enter change request title"
            >
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <select 
                name="unit" 
                id="unit" 
                class="form-select" 
                required
            >
                <option value="">-- Select Unit --</option>
                <option value="Logistics & Engineering (L&E)" {{ old('unit')=='Logistics & Engineering (L&E)' ? 'selected':'' }}>
                    Logistics & Engineering (L&E)
                </option>
                <option value="Delivery & Optimization (D&O)" {{ old('unit')=='Delivery & Optimization (D&O)' ? 'selected':'' }}>
                    Delivery & Optimization (D&O)
                </option>
                <option value="Finance" {{ old('unit')=='Finance' ? 'selected':'' }}>
                    Finance
                </option>
                <option value="Human Resource & Back End (HR)" {{ old('unit')=='Human Resource & Back End (HR)' ? 'selected':'' }}>
                    Human Resource & Back End (HR)
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="need_by_date" class="form-label">Need By Date</label>
            <input 
                type="date" 
                name="need_by_date" 
                id="need_by_date"
                class="form-control" 
                value="{{ old('need_by_date') }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="implementor_id" class="form-label">Assign to Implementor</label>
            <select 
                name="implementor_id" 
                id="implementor_id" 
                class="form-select" 
                required
            >
                <option value="">Select Implementor</option>
                @foreach($implementors as $implementor)
                    <option 
                        value="{{ $implementor->id }}" 
                        {{ old('implementor_id')==$implementor->id ? 'selected' : '' }}
                    >
                        {{ $implementor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea 
                name="comment" 
                id="comment"
                class="form-control" 
                rows="3"
                placeholder="Optional comment..."
            >{{ old('comment') }}</textarea>
        </div>

        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-wow">
                <i class="fas fa-plus me-1"></i> Submit CR
            </button>
            <a href="{{ route('change-requests.index') }}" class="btn btn-secondary ms-2">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
