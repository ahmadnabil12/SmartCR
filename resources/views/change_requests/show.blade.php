@extends('layouts.admin')

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="container mt-5 d-flex justify-content-center">
    <div class="card"
         style="border-radius:1.5rem;
                box-shadow:0 4px 32px #41acbc33;
                border:2px solid #d4f3f8;
                max-width: 440px;">
        <div class="card-body text-center">

            <!-- CR Icon -->
            <i class="fas fa-file-alt" style="font-size:4rem; color:#41acbc;"></i>

            <!-- Title -->
            <h3 class="mt-3" style="color:#41acbc;">
                {{ $changeRequest->title }}
            </h3>

            <!-- Unit -->
            <p class="mb-1 text-muted">
                <strong>Unit:</strong> {{ $changeRequest->unit }}
            </p>

            <!-- Need By Date -->
            @php
                $today = \Carbon\Carbon::today();
                $needBy = \Carbon\Carbon::parse($changeRequest->need_by_date);
                $diff = $today->diffInDays($needBy, false);
                if ($changeRequest->status === 'Completed') {
                    $bg = '#52c41a'; // Green for completed
                    $label = 'Completed';
                } elseif ($diff < 0) {
                    $bg = '#c00'; // Red - Delayed
                    $label = 'Delayed';
                } elseif ($diff <= 10) {
                    $bg = '#ff6e00'; // Orange - Urgent
                    $label = 'Urgent';
                } elseif ($diff <= 20) {
                    $bg = '#ffd700'; // Yellow - Important
                    $label = 'Important';
                } else {
                    $bg = '#4169e1'; // Blue - Standard
                    $label = 'Standard';
                }
            @endphp
            <!-- Need By (styled exactly like Status) -->
            <div class="mb-3">
                <strong>Need By:</strong>
                <span class="badge"
                    style="background: {{ $bg }};
                        color: #fff;
                        font-size: 1rem;
                        padding: .5em 1em;">
                    {{ $needBy->format('d M Y') }} ({{ $label }})
                </span>
            </div>

            <!-- Status Badge (show to all roles) -->
            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge"
                    style="background:#41acbc;
                            color:#fff;
                            font-size:1rem;
                            padding:.5em 1em;">
                    {{ $changeRequest->status }}
                </span>
            </div>

            <!-- Show complexity -->
            <p class="mb-2">
                <strong>Complexity:</strong>
                {{ $changeRequest->complexity ?? 'Not Assigned' }}
            </p>

            <!-- Implementor & Requestor -->
            <p class="mb-2"><strong>Implementor:</strong> {{ $changeRequest->implementor->name ?? 'Not Assigned' }}</p>
            <p class="mb-3"><strong>Requestor:</strong>   {{ $changeRequest->requestor->name  ?? 'Unknown'      }}</p>

            <!-- Comment -->
            <p class="text-muted mb-4">
                <strong>Comment:</strong>
                {{ $changeRequest->comment ?? '— No comment provided —' }}
            </p>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex justify-content-center gap-3">
                <!-- Edit button if they can edit -->
                @if(in_array($user->role, ['implementor','hou','hod','requestor']))
                    <a href="{{ route('change-requests.edit', $changeRequest->id) }}"
                       class="btn btn-wow btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif
                <a href="{{ route('change-requests.index') }}"
                   class="btn btn-secondary btn-sm">
                    Back to List
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
