@extends('layouts.admin')

@section('content')
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
        <!-- Dashboard Summary -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total CRs
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $changeRequests->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $changeRequests->where('status', '!=', 'Completed')->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Completed
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $changeRequests->where('status', 'Completed')->count() }}
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
