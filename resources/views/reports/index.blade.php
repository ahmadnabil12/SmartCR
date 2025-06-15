@extends('layouts.admin')

@php
    use Carbon\Carbon;
    $today = Carbon::today();

    // Initialize counters
    $delayedCount = 0;
    $urgentCount = 0;
    $importantCount = 0;
    $standardCount = 0;

    foreach ($changeRequests as $cr) {
        $needBy = Carbon::parse($cr->need_by_date);
        $diff = $today->diffInDays($needBy, false); // negative if past

        if ($diff < 0) {
            $delayedCount++;
        } elseif ($diff <= 10) {
            $urgentCount++;
        } elseif ($diff <= 20) {
            $importantCount++;
        } else {
            $standardCount++;
        }
    }
@endphp

@section('content')

<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('welcome') }}" style="color: #41acbc; font-weight: 500;">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" style="color: #41acbc; font-weight: 500;">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #888;">
                    Reports
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mt-4">
    <h2 style="color:#41acbc;" class="fw-bold mb-4">
        <i class="fas fa-chart-bar me-2"></i>
        Change Request Report
    </h2>
    <!-- Date Range Filter Form -->
    <form action="{{ route('reports.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-auto">
            <label for="from" class="form-label">From:</label>
            <input type="date" name="from" id="from" class="form-control" value="{{ $from ?? '' }}" required>
        </div>
        <div class="col-auto">
            <label for="to" class="form-label">To:</label>
            <input type="date" name="to" id="to" class="form-control" value="{{ $to ?? '' }}" required>
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-wow"><i class="fas fa-filter"></i> Filter</button>
        </div>
        @if(isset($changeRequests) && $changeRequests->count())
        <div class="col-auto align-self-end">
            <a href="{{ route('reports.downloadPdf', ['from' => $from, 'to' => $to]) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
        @endif
    </form>

    @if(isset($changeRequests) && $changeRequests->count())
        <!-- Dashboard Summary (Total CRs, Pending, Completed -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Change Requests
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $changeRequests->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    CR's Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $changeRequests->where('status', '!=', 'Completed')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    CR's Completed
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $changeRequests->where('status', 'Completed')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Request Status Breakdown (Delayed, Urgent, Important, Standard -->
        <div class="row mb-4">
            <!-- Delayed -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card shadow h-100 py-2" style="border-left:4px solid #c00f; min-height:90px;">
                    <div class="card-body d-flex align-items-center py-2 px-3" style="gap:8px;">
                        <span>
                            <i class="fas fa-exclamation-circle" style="color:#c00; font-size:1.35rem;"></i>
                        </span>
                        <div>
                            <div style="color:#c00; font-size:.95rem; font-weight:700;">Delayed</div>
                            <div style="font-size:1.3rem; font-weight:600;">{{ $delayedCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Urgent -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card shadow h-100 py-2" style="border-left:4px solid #ff6e00; min-height:90px;">
                    <div class="card-body d-flex align-items-center py-2 px-3" style="gap:8px;">
                        <span>
                            <i class="fas fa-bolt" style="color:#ff6e00; font-size:1.35rem;"></i>
                        </span>
                        <div>
                            <div style="color:#ff6e00; font-size:.95rem; font-weight:700;">Urgent</div>
                            <div style="font-size:1.3rem; font-weight:600;">{{ $urgentCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Important -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card shadow h-100 py-2" style="border-left:4px solid #ffd700; min-height:90px;">
                    <div class="card-body d-flex align-items-center py-2 px-3" style="gap:8px;">
                        <span>
                            <i class="fas fa-star" style="color:#ffd700; font-size:1.35rem;"></i>
                        </span>
                        <div>
                            <div style="color:#ffd700; font-size:.95rem; font-weight:700;">Important</div>
                            <div style="font-size:1.3rem; font-weight:600;">{{ $importantCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Standard -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card shadow h-100 py-2" style="border-left:4px solid #4169e1; min-height:90px;">
                    <div class="card-body d-flex align-items-center py-2 px-3" style="gap:8px;">
                        <span>
                            <i class="fas fa-check" style="color:#4169e1; font-size:1.35rem;"></i>
                        </span>
                        <div>
                            <div style="color:#4169e1; font-size:.95rem; font-weight:700;">Standard</div>
                            <div style="font-size:1.3rem; font-weight:600;">{{ $standardCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List of CRs -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                List of Change Requests
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Need By</th>
                            <th>Requestor</th>
                            <th>Implementor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($changeRequests as $i => $cr)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $cr->title }}</td>
                            <td>{{ $cr->unit }}</td>
                            <td>{{ $cr->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M Y') }}</td>
                            <td>{{ $cr->requestor->name ?? '-' }}</td>
                            <td>{{ $cr->implementor->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request('from') && request('to'))
        <div class="alert alert-warning mt-4">No CRs found for the selected date range.</div>
    @endif
</div>
@endsection
