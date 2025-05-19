@extends('layouts.admin')
@section('content')

<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-primary">Welcome, {{ auth()->user()->name }}!</h4>
                <p class="mb-0">You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>.</p>
            </div>
        </div>
    </div>
</div>

<!-- Change Requests Summary -->

@php
    $user = Auth::user();
    $label = match($user->role) {
        'requestor' => 'Your Submitted CRs',
        'implementor' => 'Assigned CRs',
        default => 'Total Change Requests'
    };
@endphp

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ $label }}
                    </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $crCount ?? 'N/A' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more cards if needed -->
</div>

<!-- About SmartCR -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">About SmartCR</h6>
            </div>
            <div class="card-body">
                <p><strong>SmartCR</strong> is a Change Request Management System designed for TNB's ERP department. It helps manage and track software change requests efficiently, from request submission to approval, testing, and deployment.</p>
                <p>The system supports different user roles including Requestor, Implementor, HOU, and HOD — each with different permissions and dashboard visibility.</p>
            </div>
        </div>
    </div>
</div>

@endsection
