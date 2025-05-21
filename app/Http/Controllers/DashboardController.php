<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ChangeRequest;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // ——————————————————————————————
        // 1) SUMMARY COUNTS & LABEL
        // ——————————————————————————————
        if ($user->role === 'requestor') {
            $crCount        = ChangeRequest::where('requestor_id', $user->id)->count();
            $pendingCount   = ChangeRequest::where('requestor_id', $user->id)
                                ->where('status', '!=', 'Completed')
                                ->count();
            $completedCount = ChangeRequest::where('requestor_id', $user->id)
                                ->where('status', 'Completed')
                                ->count();
            $label = 'Your Submitted CRs';
        }
        elseif ($user->role === 'implementor') {
            $crCount        = ChangeRequest::where('implementor_id', $user->id)->count();
            $pendingCount   = ChangeRequest::where('implementor_id', $user->id)
                                ->where('status', '!=', 'Completed')
                                ->count();
            $completedCount = ChangeRequest::where('implementor_id', $user->id)
                                ->where('status', 'Completed')
                                ->count();
            $label = 'Assigned CRs';
        }
        elseif ($user->role === 'hou') {
            $crCount        = ChangeRequest::where('unit', $user->unit)->count();
            $pendingCount   = ChangeRequest::where('unit', $user->unit)
                                ->where('status', '!=', 'Completed')
                                ->count();
            $completedCount = ChangeRequest::where('unit', $user->unit)
                                ->where('status', 'Completed')
                                ->count();
            $label = 'Unit CRs (' . $user->unit . ')';
        }
        else { // HOD
            $crCount        = ChangeRequest::count();
            $pendingCount   = ChangeRequest::where('status', '!=', 'Completed')->count();
            $completedCount = ChangeRequest::where('status', 'Completed')->count();
            $label = 'Total Change Requests';
        }

        // ——————————————————————————————
        // 2) UNIT CHART (only for requestor & HOD)
        // ——————————————————————————————
        if ($user->role === 'requestor') {
            $unitChart = ChangeRequest::where('requestor_id', $user->id)
                ->select('unit', DB::raw('count(*) as total'))
                ->groupBy('unit')
                ->pluck('total', 'unit');
        }
        elseif ($user->role === 'hod') {
            $unitChart = ChangeRequest::select('unit', DB::raw('count(*) as total'))
                ->groupBy('unit')
                ->pluck('total', 'unit');
        }
        else {
            $unitChart = collect();
        }

        // ——————————————————————————————
        // 3) BASE QUERY FOR CHARTS
        // ——————————————————————————————
        $base = match ($user->role) {
            'requestor'   => ChangeRequest::where('requestor_id',   $user->id),
            'implementor' => ChangeRequest::where('implementor_id', $user->id),
            'hou'         => ChangeRequest::where('unit',           $user->unit),
            default       => ChangeRequest::query(),
        };

        // ——————————————————————————————
        // 4) CHART DATASETS (each uses a clone of $base)
        // ——————————————————————————————

        // Status Doughnut
        $statusChart = (clone $base)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status');

        // Complexity Horizontal Bar
        $complexityChart = (clone $base)
            ->select('complexity', DB::raw('count(*) as total'))
            ->groupBy('complexity')
            ->pluck('total', 'complexity');

        // Completed vs Pending Pie
        $completionChart = (clone $base)
            ->select(
                DB::raw("CASE WHEN status = 'Completed' THEN 'Completed' ELSE 'Pending' END as completion_status"),
                DB::raw('count(*) as total')
            )
            ->groupBy('completion_status')
            ->pluck('total', 'completion_status');

        // ——————————————————————————————
        // 5) RETURN VIEW
        // ——————————————————————————————
        return view('dashboard', [
            'crCount'         => $crCount,
            'pendingCount'    => $pendingCount,
            'completedCount'  => $completedCount,
            'label'           => $label,
            'unitChart'       => $unitChart,
            'statusChart'     => $statusChart,
            'complexityChart' => $complexityChart,
            'completionChart' => $completionChart,
        ]);
    }
}
