@extends('layouts.admin')

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">

    <!--Breadcrumb-->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Change Requests</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <h1 class="text-center text-dark">List of Change Requests</h1>
        </div>
    </div>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; border-color: #218838; color: white;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; border-color: #c82333; color: white;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Add New Change Request button (optional for requestor only) -->
    @if ($user->role === 'requestor')
        <div class="mb-3">
            <a href="{{ route('change-requests.create') }}" class="btn btn-success btn-lg" style="background-color: #28a745; border-color: #218838; color: white;">Submit New CR</a>
        </div>
    @endif

    <!-- Table to display change requests -->
    <div class="card shadow-sm" style="background-color: #ffffff; border-color: #ddd;">
        <div class="card-body">
            <table class="table table-hover table-bordered table-striped" style="background-color: #f9f9f9; color: #2c3e50;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Title</th>
                        <th>Unit</th>
                        <th>Need By</th>
                        @if (in_array($user->role, ['implementor', 'hou', 'hod']))
                            <th>Status</th>
                            <th>Complexity</th>
                        @endif
                        <th>Implementor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($changeRequests as $cr)
                        <tr>
                            <td>{{ $cr->title }}</td>
                            <td>{{ $cr->unit }}</td>
                            <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M, Y') }}</td>
                            @if ($user->role !== 'requestor')
                                <td>{{ $cr->status }}</td>
                                <td>{{ $cr->complexity ?? 'N/A' }}</td>
                            @endif
                            <td>{{ $cr->implementor->name ?? 'Not Assigned' }}</td>
                            <td class="d-flex">
                                <!-- View Button -->
                                <a href="{{ route('change-requests.show', $cr->id) }}" class="btn btn-info btn-sm me-2" style="background-color: #17a2b8; border-color: #117a8b; color: white; margin-right: 5px;">View</a>

                                <!-- Edit Button -->
                                <a href="{{ route('change-requests.edit', $cr->id) }}" class="btn btn-secondary btn-sm me-2" style="background-color: #007bff; border-color: #0069d9; color: white; margin-right: 5px;">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('change-requests.destroy', $cr->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="background-color: #e74c3c; border-color: #c0392b; margin-right: 5px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $user->role !== 'requestor' ? 7 : 5 }}" class="text-center">No change requests available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
