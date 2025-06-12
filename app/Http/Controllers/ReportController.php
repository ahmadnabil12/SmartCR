<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $from = $request->input('from');
        $to = $request->input('to');

        $query = \App\Models\ChangeRequest::query();

        // Role-based filtering
        if ($user->role === 'hou') {
            $query->where('unit', $user->unit);
        } elseif ($user->role === 'hod') {
            // filter by HOD's department/unit if needed
        }

        // Date range filtering
        if ($from && $to) {
            $query->whereBetween('need_by_date', [$from, $to]);
        }

        $changeRequests = $query->get();

        return view('reports.index', compact('changeRequests', 'from', 'to'));
    }

    public function downloadPdf(Request $request)
    {
        $user = auth()->user();
        $from = $request->input('from');
        $to   = $request->input('to');

        $query = \App\Models\ChangeRequest::query();

        // Restrict for HOU
        if ($user->role === 'hou') {
            $query->where('unit', $user->unit);
        }

        // Date filter
        if ($from && $to) {
            $query->whereBetween('need_by_date', [$from, $to]);
        }

        $changeRequests = $query->with(['requestor', 'implementor'])->get();

        // Summary cards (just like dashboard)
        $crCount       = $changeRequests->count();
        $pendingCount  = $changeRequests->where('status', '!=', 'Completed')->count();
        $completedCount= $changeRequests->where('status', 'Completed')->count();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', [
            'crCount'        => $crCount,
            'pendingCount'   => $pendingCount,
            'completedCount' => $completedCount,
            'changeRequests' => $changeRequests,
            'from'           => $from,
            'to'             => $to,
        ]);

        return $pdf->download('ChangeRequestsReport_' . now()->format('Ymd_His') . '.pdf');
    }
}