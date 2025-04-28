@extends('layouts.admin')

@section('content')
<div class="container mt-5" style="background-color: #f4f6f9; color: #2c3e50; padding: 20px; border-radius: 10px;">

    <!--Breadcrumb-->
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Milestones</li>
          </ol>
        </nav>
      </div>
    </div>

    <h1 class="text-center text-dark mb-4">
        List of Milestones
    </h1>

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

   <!-- Add Milestone Button -->
   @can('isLeader', $grant)
    <div class="mb-3">
        <a href="{{ route('milestones.create', $grant->id) }}" class="btn btn-lg" style="background-color: #28a745; border-color: #218838; color: white;">Add New Milestone</a>
    </div>
    @endcan

    <!-- Table to display milestones -->
    <div class="card shadow-sm" style="background-color: #ffffff; border-color: #ddd;">
        <div class="card-body">
            <table class="table table-hover table-bordered table-striped" style="background-color: #f9f9f9; color: #2c3e50;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Milestone Title</th>
                        <th>Grant Associated</th>
                        <th>Completion Date</th>
                        <th>Deliverable</th>
                        <th>Status</th>
                        <th>Remark</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($milestones as $milestone)
                        <tr>
                            <td>{{ $milestone->milestone_title }}</td>
                            <td>{{ $milestone->grant->project_title }}</td>
                            <td>{{ \Carbon\Carbon::parse($milestone->completion_date)->format('d M, Y') }}</td>
                            <td>{{ $milestone->deliverable }}</td>
                            <td>{{ $milestone->status }}</td>
                            <td>{{ $milestone->remark }}</td>
                            <td class="d-flex">
                                <!-- View Button -->
                                <a href="{{ route('milestones.show', $milestone->id) }}" class="btn btn-sm me-2" style="background-color: #17a2b8; border-color: #117a8b; color: white; margin-right: 5px;">View</a>

                                @can('isLeader', $grant)
                                <!-- Edit Button (only for leader) -->
                                <a href="{{ route('milestones.edit', $milestone->id) }}" class="btn btn-sm me-2" style="background-color: #007bff; border-color: #0069d9; color: white; margin-right: 5px;">Edit</a>
                                
                                <!-- Delete Button (only for leader) -->
                                <form action="{{ route('milestones.destroy', $milestone->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="background-color: #e74c3c; border-color: #c0392b; margin-right: 5px;">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No milestones available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
