@extends('layouts.admin')
@section('content')

<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="border-radius:1.5rem; box-shadow:0 4px 32px #41acbc33; border:2px solid #d4f3f8; max-width: 440px;">
        <div class="card-body text-center">
            <i class="fas fa-user-circle" style="font-size:4rem; color:#41acbc;"></i>
            <h3 class="mt-3" style="color:#41acbc;">{{ $user->name }}</h3>
            <p class="mb-2 text-muted">{{ $user->email }}</p>
            <div class="mb-3">
                <span class="badge" style="background:#41acbc; color:#fff; font-size:1rem; padding:.5em 1em;">
                    @if($user->role == 'hou') Head Of Unit (HOU)
                    @elseif($user->role == 'hod') Head Of Department (HOD)
                    @elseif($user->role == 'admin') Admin
                    @else {{ ucfirst($user->role) }}
                    @endif
                </span>
            </div>
            @if($user->unit)
                <div><strong>Unit:</strong> {{ $user->unit }}</div>
            @endif
            <div class="mt-4 d-flex justify-content-center gap-3">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-wow btn-sm me-2"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
