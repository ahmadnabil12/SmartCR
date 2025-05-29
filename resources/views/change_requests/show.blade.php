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

            <!-- Unit & Need-By -->
            <p class="mb-1 text-muted">
                <strong>Unit:</strong> {{ $changeRequest->unit }}
            </p>
            <p class="mb-3 text-muted">
                <strong>Need By:</strong>
                {{ \Carbon\Carbon::parse($changeRequest->need_by_date)->format('d M, Y') }}
            </p>

            <!-- Status Badge (for implementor/hou/hod) -->
            @if(in_array($user->role, ['implementor','hou','hod']))
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
                <p class="mb-3">
                    <strong>Complexity:</strong>
                    {{ $changeRequest->complexity ?? 'Not Assigned' }}
                </p>
            @endif

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
                {{-- Edit button if they can edit --}}
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
