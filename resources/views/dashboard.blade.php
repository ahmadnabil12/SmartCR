@extends('layouts.admin')
@section('content')

<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('welcome') }}" style="color: #41acbc; font-weight: 500;">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #888;">
                    Dashboard
                </li>
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
                <p class="mb-0">You are logged in as <strong>{{ auth()->user()->role_label }}</strong>.</p>
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
    <!-- Change Request Count Card -->
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
            <i class="fas fa-file-alt fa-2x text-primary"></i>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- CR's Pending Count Card -->
    <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                CR's Pending 
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount ?? 'N/A' }}</div>
            </div>
            <div class="col-auto">
            <i class="fas fa-clock fa-2x text-warning"></i>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- CR's Completed Count Card -->
    <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                CR's Completed
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedCount ?? 'N/A' }}</div>
            </div>
            <div class="col-auto">
            <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- CR List Card -->
<div class="row mb-4">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header bg-info text-white">
        Recent CRs
      </div>
      <div class="card-body p-0">
        @if($recentCRs->isEmpty())
          <p class="text-center my-3">No recent CRs.</p>
        @else
          <ul class="list-group list-group-flush">
            @foreach($recentCRs as $cr)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $cr->title }}</strong><br>
                  <small class="text-muted">{{ $cr->created_at->format('d M, Y H:i') }}</small>
                </div>
                <div>
                  <a href="{{ route('change-requests.show', $cr->id) }}"
                     class="btn btn-sm btn-primary">
                    View
                  </a>
                  @if(in_array(Auth::user()->role, ['hod','hou','implementor']))
                    <a href="{{ route('change-requests.edit', $cr->id) }}"
                       class="btn btn-sm btn-secondary">
                      Edit
                    </a>
                  @endif
                </div>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('change-requests.index') }}">See all CRs &rarr;</a>
      </div>
    </div>
  </div>
</div>

<!-- Status Message Card (for requestor with no CRs) -->
@if(auth()->user()->role === 'requestor' && $crCount == 0)
<div class="row">
    <div class="col-xl-6 mb-4">
        <div class="card shadow text-center fade-in-card">
            <div class="card-header bg-primary text-white">
                CR Status Distribution
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">You haven't submitted any Change Requests yet.</p>
                <p class="text-muted">Once you do, you'll see your progress visualized here!</p>
                <a href="{{ route('change-requests.create') }}" class="btn btn-sm btn-primary">
                    Submit New CR
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- === Dynamic Charts Display (No Holes!) === -->
@php
    $charts = [];
    // Status chart is for everyone if available
    if (isset($statusChart) && $statusChart->isNotEmpty()) {
        $charts[] = [
            'id' => 'statusDoughnutChart',
            'header' => 'CR Status Distribution',
            'headerClass' => 'bg-primary',
            'cardClass' => 'fade-in-card',
        ];
    }
    // Only show complexity for non-requestors
    if (
        isset($complexityChart) && $complexityChart->isNotEmpty() &&
        in_array(auth()->user()->role, ['hod','hou','implementor','admin'])
    ) {
        $charts[] = [
            'id' => 'complexityBarChart',
            'header' => 'CR Complexity Distribution',
            'headerClass' => 'bg-success',
            'cardClass' => 'fade-in-card',
        ];
    }
    if (isset($unitChart) && $unitChart->isNotEmpty()) {
        $charts[] = [
            'id' => 'unitBarChart',
            'header' => 'CRs by Unit',
            'headerClass' => 'bg-info',
            'cardClass' => '',
        ];
    }
    if (isset($completionChart) && $completionChart->isNotEmpty()) {
        $charts[] = [
            'id' => 'completionPieChart',
            'header' => 'Completed vs Pending CRs',
            'headerClass' => 'bg-warning',
            'cardClass' => '',
        ];
    }
@endphp

<!-- 2. Loop through charts, 2 per row -->
@if(count($charts))
    @foreach(array_chunk($charts, 2) as $rowCharts)
    <div class="row mb-4">
        @foreach($rowCharts as $chart)
        <div class="col-xl-6 mb-4">
            <div class="card shadow {{ $chart['cardClass'] }}">
                <!-- Chart Header (colored) -->
                <div class="card-header text-white {{ $chart['headerClass'] }}">
                    {{ $chart['header'] }}
                </div>
                <!---- Chart Canvas -->
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="{{ $chart['id'] }}" width="400" height="400" style="max-width:400px;max-height:400px; display:block; margin:auto;"></canvas>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
@endif
<!-- End of Charts Row -->

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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- CR Status Doughnut Chart -->
@if(isset($statusChart) && $statusChart->isNotEmpty() && !(auth()->user()->role === 'requestor' && $crCount == 0))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('statusDoughnutChart')?.getContext('2d');

    // 1) pull labels & data from Blade
    const statusLabels = {!! json_encode($statusChart->keys()) !!};
    const statusData   = {!! json_encode($statusChart->values()) !!};
    const totalCR      = statusData.reduce((a, b) => a + b, 0);

    // 2) center-text plugin (unchanged)
    const centerTextPlugin = {
    id: 'centerText',
        beforeDraw(chart) {
            const { ctx, chartArea: { left, right, top, bottom } } = chart;
            const centerX = (left + right) / 2;
            const centerY = (top + bottom) / 2;
            const text = `Total CR: ${totalCR}`;

            ctx.save();
            ctx.font         = '18px Nunito, sans-serif';
            ctx.fillStyle    = '#333';
            ctx.textAlign    = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(text, centerX, centerY);
            ctx.restore();
        }
    };

    // 3) explicit color map (add or adjust statuses as needed)
    const statusColorMap = {
        'Requirement Gathering':   '#007bff',
        'Feasibility Study':       '#6c757d',
        'SOW Preparation':   '#17a2b8',
        'SOW Sign Off': '#ffc107',
        'Quotation Preparation':     '#fd7e14',
        'Quotation Sign Off':    '#20c997',
        'Development Plan':    '#dc3545',
        'Development':     '#6f42c1',
        'SIT':   '#e83e8c',
        'UAT':     '#343a40',
        'UAT Sign Off':      '#6610f2',
        'Deployment':    '#f8f9fa',
        'Completed':   '#28a745',
    };

    // 4) build the backgroundColor array in label-order
    const backgroundColor = statusLabels.map(label =>
        statusColorMap[label] ?? '#cccccc'  // fallback grey if you ever add a new status
    );

    // 5) render the doughnut
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    /*title: {
                        display: true,
                        text: 'Change Request Status Distribution'
                    },*/
                    tooltip: {
                        callbacks: {
                            label: ctx => {
                                const v = ctx.raw;
                                const pct = ((v / totalCR) * 100).toFixed(1);
                                return `${ctx.label}: ${v} (${pct}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [centerTextPlugin]
        });
    }
});
</script>
@endif

<!-- CR Complexity Horizontal Bar Graph -->
@if(isset($complexityChart) && $complexityChart->isNotEmpty() && !(auth()->user()->role === 'requestor' && $crCount == 0))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx2 = document.getElementById('complexityBarChart')?.getContext('2d');
    const complexityChart = {
        'High': {{ $complexityChart['High'] ?? 0 }},
        'Medium': {{ $complexityChart['Medium'] ?? 0 }},
        'Low': {{ $complexityChart['Low'] ?? 0 }}
    };
    const complexityLabels = Object.keys(complexityChart); 
    const complexityData = Object.values(complexityChart);
    const totalComplexity = complexityData.reduce((a, b) => a + b, 0);

    if (ctx2) {
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: complexityLabels,
                datasets: [{
                    label: 'CR Count',
                    data: complexityData,
                    backgroundColor: ['#dc3545', '#17a2b8', '#ffc107'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    /*title: {
                        display: true,
                        text: 'Change Request Complexity Distribution'
                    },*/
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.raw;
                                const percentage = ((value / totalComplexity) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    }
});
</script>
@endif

<!-- CRs by Unit Bar Chart -->
@if((auth()->user()->role === 'requestor' || auth()->user()->role === 'hod' || auth()->user()->role === 'admin') && isset($unitChart) && $unitChart->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx3 = document.getElementById('unitBarChart')?.getContext('2d');
    const labels = {!! json_encode($unitChart->keys()) !!};
    const values = {!! json_encode($unitChart->values()) !!};
    if (ctx3) {
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: {!! json_encode($unitChart->keys()) !!},
                datasets: [{
                    label: 'CRs by Unit',
                    data: {!! json_encode($unitChart->values()) !!},
                    backgroundColor: '#007bff',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    /*title: {
                        display: true,
                        text: 'CRs by Unit'
                    },*/
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#333',
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 13
                            },
                            callback: function(value) {
                                // Split label by spaces, so each word goes to a new line
                                const label = this.getLabelForValue(value);
                                return label ? label.split(' ') : label;
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }
});
</script>
@endif

<!-- Completed vs Pending Pie Chart -->
@if(isset($completionChart) && $completionChart->isNotEmpty() && !(auth()->user()->role === 'requestor' && $crCount == 0))
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('completionPieChart')?.getContext('2d');
  const raw = {!! json_encode($completionChart) !!};
  const labels = ['Pending','Completed'];
  const data = labels.map(l => raw[l] ?? 0);
  const backgroundColor = ['#ffc107','#28a745'];

  if (ctx) {
    new Chart(ctx, {
      type: 'pie',
      data: { labels, datasets: [{ data, backgroundColor, borderColor: '#fff', borderWidth: 1 }] },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' },
          //title: { display: true }, text: 'Completed vs Pending CRs' },
          tooltip: {
            callbacks: {
              label: ctx => {
                const v = ctx.raw;
                const pct = ((v / data.reduce((a,b)=>a+b,0))*100).toFixed(1);
                return `${ctx.label}: ${v} (${pct}%)`;
              }
            }
          }
        }
      }
    });
  }
});
</script>
@endif
@endpush
