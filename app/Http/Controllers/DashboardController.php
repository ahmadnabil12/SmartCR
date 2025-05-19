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

        // Initialize common variables
        $unitChart = collect();         
        $completionChart = collect();   

        // Role-based data setup
        if ($user->role === 'requestor') {
            $crCount = ChangeRequest::where('requestor_id', $user->id)->count();
            $label = 'Your Submitted CRs';

            // CRs grouped by unit for this requestor
            $unitChart = ChangeRequest::where('requestor_id', $user->id)
                ->select('unit', DB::raw('count(*) as total'))
                ->groupBy('unit')
                ->pluck('total', 'unit');

        } elseif ($user->role === 'implementor') {
            $crCount = ChangeRequest::where('implementor_id', $user->id)->count();
            $label = 'Assigned CRs';

        } elseif ($user->role === 'hou') {
            $crCount = ChangeRequest::where('unit', $user->unit)->count();
            $label = 'Unit CRs (' . $user->unit . ')';

        } else { // HOD
            $crCount = ChangeRequest::count();
            $label = 'Total Change Requests';

            // CRs grouped by unit (for all users)
            $unitChart = ChangeRequest::select('unit', DB::raw('count(*) as total'))
                ->groupBy('unit')
                ->pluck('total', 'unit');
        }

        // Determine query scope for charts
        $crQuery = match($user->role) {
            'requestor' => ChangeRequest::where('requestor_id', $user->id),
            'implementor' => ChangeRequest::where('implementor_id', $user->id),
            'hou' => ChangeRequest::where('unit', $user->unit),
            default => ChangeRequest::query(),
        };

        // CR Status Doughnut Chart
        $statusChart = $crQuery
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status');

        // CR Complexity Chart
        $complexityChart = $crQuery
            ->select('complexity', DB::raw('count(*) as total'))
            ->groupBy('complexity')
            ->pluck('total', 'complexity');

        // Completed vs Pending Chart
        $completionChart = $crQuery
            ->select(DB::raw("CASE 
                                WHEN status = 'Completed' THEN 'Completed' 
                                ELSE 'Pending' 
                            END as completion_status"), 
                    DB::raw('count(*) as total'))
            ->groupBy('completion_status')
            ->pluck('total', 'completion_status');

        return view('dashboard', [
            'crCount' => $crCount,
            'label' => $label,
            'statusChart' => $statusChart,
            'complexityChart' => $complexityChart,
            'unitChart' => $unitChart,              
            'completionChart' => $completionChart 
        ]);
    }
}
