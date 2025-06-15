<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Change Request Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 18px; }
        .summary-cards { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .card { padding: 10px 18px; border-radius: 8px; font-size: 1.1em; flex:1; margin: 0 10px; }
        .card-total { background: #e3f2fd; color: #1565c0; }
        .card-pending { background: #fffde7; color: #fbc02d; }
        .card-completed { background: #e8f5e9; color: #388e3c; }
        h2 { color: #41acbc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 10px; border: 1px solid #ccc; font-size: 0.95em; }
        th { background: #41acbc; color: #fff; }
        .footer { margin-top: 32px; font-size: 0.95em; color: #888; text-align:center;}
        .mb-2 { margin-bottom: 16px; }
        .center { text-align: center; }
        .chart-img { display:block; margin: 18px auto; max-width: 360px; }

        .urgency-completed { background: #52c41a; color: #fff; }
        .urgency-delayed   { background: #c00; color: #fff; }
        .urgency-urgent    { background: #ff6e00; color: #fff; }
        .urgency-important { background: #ffd700; color: #fff; }
        .urgency-standard  { background: #4169e1; color: #fff; }
        .urgency-badge {
            display: inline-block;
            width: 100%;
            height: 100%;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Change Request Report</h2>
        <div>Date Range: <strong>{{ \Carbon\Carbon::parse($from)->format('d M Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($to)->format('d M Y') }}</strong></div>
        <div>Generated on: {{ now()->format('d M Y H:i') }}</div>
        <div>User: <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }})</div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card card-total center">
            <div style="font-size:1.6em;">{{ $changeRequests->count() }}</div>
            <div>Total CRs</div>
        </div>
        <div class="card card-pending center">
            <div style="font-size:1.6em;">
                {{ $changeRequests->where('status','!=','Completed')->count() }}
            </div>
            <div>Pending</div>
        </div>
        <div class="card card-completed center">
            <div style="font-size:1.6em;">
                {{ $changeRequests->where('status','Completed')->count() }}
            </div>
            <div>Completed</div>
        </div>
    </div>

    <!-- Status Breakdown (Date) -->
    <table width="100%" style="margin: 18px 0;">
        <tr>
            <td align="center" style="background:#c00; color:#fff; padding: 10px 0; border-radius: 8px; font-weight:bold;">
                Delayed<br>{{ $delayedCount }}
            </td>
            <td align="center" style="background:#ff6e00; color:#fff; padding: 10px 0; border-radius: 8px; font-weight:bold;">
                Urgent<br>{{ $urgentCount }}
            </td>
            <td align="center" style="background:#ffd700; color:#333; padding: 10px 0; border-radius: 8px; font-weight:bold;">
                Important<br>{{ $importantCount }}
            </td>
            <td align="center" style="background:#4169e1; color:#fff; padding: 10px 0; border-radius: 8px; font-weight:bold;">
                Standard<br>{{ $standardCount }}
            </td>
        </tr>
    </table>

    <!-- Insights Section -->
    @php
        $mostActiveUnit = $changeRequests->groupBy('unit')->sortByDesc(fn($crs) => $crs->count())->keys()->first();
        $mostCommonStatus = $changeRequests->groupBy('status')->sortByDesc(fn($crs) => $crs->count())->keys()->first();
    @endphp

    <div style="margin-bottom: 18px; margin-top:8px;">
        <strong>Insights:</strong>
        <ul style="margin:0 0 0 18px; padding:0;">
             <!-- Show 'Most Active Unit' only to HOD and Admin -->
            @if(in_array(auth()->user()->role, ['hod', 'admin']))
                <li>Most active unit: <strong>{{ $mostActiveUnit ?? '-' }}</strong></li>
            @endif
            <!-- Show 'Most Common Status' -->
            <li>Most common status: <strong>{{ $mostCommonStatus ?? '-' }}</strong></li>
            <!-- Average Days from Submission to Need By -->
            <li>Average days from submission to Need By: <strong>
                @if($changeRequests->count())
                    {{
                        round($changeRequests->avg(function($cr){
                            return \Carbon\Carbon::parse($cr->need_by_date)->diffInDays($cr->created_at, false);
                        }), 1)
                    }} days
                @else
                    N/A
                @endif
            </strong></li>
            <!-- Implementor with Most Delayed CRs -->
            @php
                $delayedByImpl = $changeRequests
                    ->filter(fn($cr) => \Carbon\Carbon::parse($cr->need_by_date)->isPast() && $cr->status !== 'Completed')
                    ->groupBy(fn($cr) => $cr->implementor->name ?? 'None')
                    ->map(fn($group) => $group->count());
                $maxDelayed = $delayedByImpl->max();
                $mostDelayedImpl = $delayedByImpl->filter(fn($v) => $v === $maxDelayed && $maxDelayed > 0)->keys()->implode(', ');
            @endphp
            <li>
                Implementor with most delayed CRs:
                <strong>{{ $mostDelayedImpl ?: 'None' }}</strong>
                @if($maxDelayed > 0)
                    ({{ $maxDelayed }})
                @endif
            </li>
            <!-- Implementor with Most Assigned CRs -->
            @php
                $assignedByImpl = $changeRequests
                    ->groupBy(fn($cr) => $cr->implementor->name ?? 'None')
                    ->map(fn($group) => $group->count());
                $maxAssigned = $assignedByImpl->max();
                $mostAssignedImpl = $assignedByImpl->filter(fn($v) => $v === $maxAssigned && $maxAssigned > 0)->keys()->implode(', ');
            @endphp
            <li>
                Implementor with most assigned CRs:
                <strong>{{ $mostAssignedImpl ?: 'None' }}</strong>
                @if($maxAssigned > 0)
                    ({{ $maxAssigned }})
                @endif
            </li>
        </ul>
    </div>


    <!-- Optional: You can show counts by Unit or any other metric here! -->

    <!-- (OPTIONAL) Bar/Donut/Pie Chart Images (see below for instructions) -->
    @if(isset($chartImages['status']))
        <img src="{{ $chartImages['status'] }}" class="chart-img" alt="Status Chart">
    @endif
    @if(isset($chartImages['unit']))
        <img src="{{ $chartImages['unit'] }}" class="chart-img" alt="Unit Chart">
    @endif

    <!-- CR List Table -->
    <h3 class="mb-2">List of Change Requests</h3>
    <table>
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
                @php
                    $today = \Carbon\Carbon::today();
                    $needBy = \Carbon\Carbon::parse($cr->need_by_date);
                    $diff = $today->diffInDays($needBy, false);
                    if ($cr->status === 'Completed') {
                        $urgencyClass = 'urgency-completed';
                    } elseif ($diff < 0) {
                        $urgencyClass = 'urgency-delayed';
                    } elseif ($diff <= 10) {
                        $urgencyClass = 'urgency-urgent';
                    } elseif ($diff <= 20) {
                        $urgencyClass = 'urgency-important';
                    } else {
                        $urgencyClass = 'urgency-standard';
                    }
                @endphp
                <tr>
                    <td class="{{ $urgencyClass }}" style="font-weight:bold; text-align:center;">
                        {{ $i + 1 }}
                    </td>
                    <td>{{ $cr->title }}</td>
                    <td>{{ $cr->unit }}</td>
                    <td>{{ $cr->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M Y') }}</td>
                    <td>{{ $cr->requestor->name ?? '-' }}</td>
                    <td>{{ $cr->implementor->name ?? '-' }}</td>
                </tr>
            @endforeach
            @if($changeRequests->count() == 0)
                <tr><td colspan="7" class="center">No CRs found for this date range.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Completed CRs Table -->
    @php
        $completedCRs = $changeRequests->where('status', 'Completed')->sortByDesc('need_by_date')->take(5);
    @endphp

    @if($completedCRs->count())
        <h4 class="mb-2">Recently Completed CRs</h4>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Need By</th>
                    <th>Completed Date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($completedCRs as $cr)
                <tr>
                    <td>{{ $cr->title }}</td>
                    <td>{{ $cr->unit }}</td>
                    <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M Y') }}</td>
                    <td>
                        {{ $cr->updated_at ? \Carbon\Carbon::parse($cr->updated_at)->format('d M Y') : '-' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    
    <!-- Top Delayed CRs -->
    @php
        $delayedCRs = $changeRequests->filter(function($cr){
            return \Carbon\Carbon::parse($cr->need_by_date)->isPast() && $cr->status !== 'Completed';
        })->sortBy(function($cr){
            return \Carbon\Carbon::parse($cr->need_by_date);
        })->take(3);
    @endphp

    @if($delayedCRs->count())
        <h4 class="mb-2">Top Delayed CRs</h4>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Need By</th>
                    <th>Days Overdue</th>
                </tr>
            </thead>
            <tbody>
            @foreach($delayedCRs as $cr)
                <tr>
                    <td>{{ $cr->title }}</td>
                    <td>{{ $cr->unit }}</td>
                    <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($cr->need_by_date)->diffInDays(now()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        SmartCR | TNB ERP Department &copy; {{ date('Y') }}
    </div>
</body>
</html>
