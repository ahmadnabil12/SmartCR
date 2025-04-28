@extends('layouts.admin')
@section('content')

<!--Breadcrumb-->
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

<!-- Content Row -->
<div class="row">

    <!-- Academicians Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Academicians
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $academiciansCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grants Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Grants
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $grantsCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Milestones Card -->
    <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Milestones
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $milestonesCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Content Row ->

<div class="row">

    <-- Area Chart ->
    <--div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <-- Card Header - Dropdown ->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <-- Card Body ->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div->

    <-- Pie Chart ->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <-- Card Header - Dropdown ->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
            </div>
            <-- Card Body ->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Academicians
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Grants
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Milestones
                    </span>
                </div>
            </div>
        </div>
    </div>
</div-->

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">RGMS</h6>
            </div>
            <div class="card-body">
                <!-- Academician -->
                <h4 class="small font-weight-bold">Academicians <span 
                        class="float-right">{{ $academiciansCount }}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min($academiciansCount * 1.5, 100) }}%" 
                        aria-valuenow="{{ $academiciansCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!--Grants-->
                <h4 class="small font-weight-bold">Grants <span
                        class="float-right">{{ $grantsCount }}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($grantsCount * 1.5, 100) }}%" 
                        aria-valuenow="{{ $grantsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!--Milestones-->
                <h4 class="small font-weight-bold">Milestones <span
                        class="float-right">{{ $milestonesCount }}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ min($milestonesCount * 1.5, 100) }}%"
                        aria-valuenow="{{ $milestonesCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!--h4 class="small font-weight-bold">Payout Details <span
                        class="float-right">80%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Account Setup <span
                        class="float-right">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div-->
            </div>
        </div>

        <!-- Color System -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Academicians
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Grants
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Milestones
                    </div>
                </div>
            </div>

            <!--div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                        Light
                        <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Dark
                        <div class="text-white-50 small">#5a5c69</div>
                    </div>
                </div>
            </div-->
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- About RGMS -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">About RGMS</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                        src="img/undraw_posting_photo.svg" alt="...">
                </div>
                <p>The Research Grant Management System (RGMS) is a centralized platform designed to streamline the management of research grants at UNITEN Innovation and Research Management Center (iRMC). It allows Admin Executives to input and manage project details such as project leaders, grant amounts, project titles, and team members.</p>

                <p>Each research grant is led by a project leader and includes one or more project members. The project leader is responsible for setting milestones, tracking progress, and updating the status of the project. Academicians, serving as project leaders or members, are essential to the process.</p>

                <p>RGMS enables iRMC staff to view and update project information, ensuring accurate tracking of research grants. Project leaders can also update team members and project details, facilitating efficient project management and transparent communication.</p>

                <!--a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                    unDraw &rarr;</a-->
            </div>
        </div>

        <!-- Approach ->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                    CSS bloat and poor page performance. Custom CSS classes are used to create
                    custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the
                    Bootstrap framework, especially the utility classes.</p>
            </div>
        </div-->

    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection

<!-- Inline Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Academicians", "Grants", "Milestones"], // Custom Labels
            datasets: [{
                data: [{{ $academiciansCount }}, {{ $grantsCount }}, {{ $milestonesCount }}],
                backgroundColor: ['#007bff', '#28a745', '#17a2b8'],
                hoverBackgroundColor: ['#0056b3', '#218838', '#138496'],
                hoverBorderColor: "#fff",
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw; // Display counts with labels
                        }
                    }
                }
            }
        }
    });
</script>