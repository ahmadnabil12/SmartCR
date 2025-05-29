@extends('layouts.admin')

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="wow-card">
    <div class="wow-header">
        <i class="fas fa-file-alt"></i>
        <h2 style="color:#41acbc; font-weight:800;">Edit Change Request</h2>
        <p style="color:#338fa1;">Modify the request details below</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
             style="background-color:#dc3545;border-color:#c82333;color:#fff;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('change-requests.update', $changeRequest->id) }}"
        method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        @php
            $canEditMain = in_array($user->role, ['requestor','admin']);
            $canEditStatus = in_array($user->role, ['implementor','hou','hod','admin']);
        @endphp

        <!-- Title -->
        <div class="mb-3">
            <label class="form-label" for="title">CR Title</label>
            <input type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ $changeRequest->title }}"
                @if(!$canEditMain) readonly @endif
                required>
        </div>

        <!-- Unit -->
        <div class="mb-3">
            <label class="form-label" for="unit">Unit</label>
            <select id="unit"
                    name="unit"
                    class="form-select"
                    @if(!$canEditMain) disabled @endif
                    required>
                <option value="">-- Select Unit --</option>
                <option value="Logistics and Engineering (L&E)"
                    {{ $changeRequest->unit == 'Logistics and Engineering (L&E)' ? 'selected' : '' }}>
                    Logistics and Engineering (L&E)
                </option>
                <option value="Delivery & Optimization (D&O)"
                    {{ $changeRequest->unit == 'Delivery & Optimization (D&O)' ? 'selected' : '' }}>
                    Delivery & Optimization (D&O)
                </option>
                <option value="Finance"
                    {{ $changeRequest->unit == 'Finance' ? 'selected' : '' }}>
                    Finance
                </option>
                <option value="Human Resource & Back End (HR)"
                    {{ $changeRequest->unit == 'Human Resource & Back End (HR)' ? 'selected' : '' }}>
                    Human Resource & Back End (HR)
                </option>
            </select>
        </div>

        <!-- Need By Date -->
        <div class="mb-3">
            <label class="form-label" for="need_by_date">Need By Date</label>
            <input type="date"
                id="need_by_date"
                name="need_by_date"
                class="form-control"
                value="{{ $changeRequest->need_by_date }}"
                @if(!$canEditMain) readonly @endif
                required>
        </div>

        <!-- Status/Complexity (Implementor, HOU, HOD, Admin) -->
        @if($canEditStatus)
            <div class="mb-3">
                <label class="form-label" for="status">Status</label>
                <select id="status"
                        name="status"
                        class="form-select"
                        required>
                    @foreach([
                        'Requirement Gathering','Feasibility Study','SOW Preparation',
                        'SOW Sign Off','Quotation Preparation','Quotation Sign Off',
                        'Development Plan','Development','UAT','UAT Sign Off',
                        'Deployment','Completed'
                    ] as $s)
                    <option value="{{ $s }}"
                        {{ $changeRequest->status === $s ? 'selected' : '' }}>
                        {{ $s }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="complexity">Complexity</label>
                <select id="complexity"
                        name="complexity"
                        class="form-select"
                        required>
                    @foreach(['Low','Medium','High'] as $lvl)
                    <option value="{{ $lvl }}"
                        {{ $changeRequest->complexity === $lvl ? 'selected' : '' }}>
                        {{ $lvl }}
                    </option>
                    @endforeach
                </select>
            </div>
        @else
            <!-- Show as read-only for others -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" value="{{ $changeRequest->status }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Complexity</label>
                <input type="text" class="form-control" value="{{ $changeRequest->complexity }}" readonly>
            </div>
        @endif

        <!-- Comment (always editable) -->
        <div class="mb-3">
            <label class="form-label" for="comment">Comment</label>
            <textarea id="comment"
                    name="comment"
                    class="form-control"
                    rows="3">{{ $changeRequest->comment }}</textarea>
        </div>

        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-wow">
                <i class="fas fa-save me-1"></i> Update Change Request
            </button>
            <a href="{{ route('change-requests.index') }}"
            class="btn btn-secondary ms-2">
                Cancel
            </a>
        </div>
    </form>

</div>
@endsection
