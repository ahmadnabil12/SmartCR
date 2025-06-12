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
        $to = $request->input('to');

        $query = \App\Models\ChangeRequest::query();

        if ($user->role === 'hou') {
            $query->where('unit', $user->unit);
        }
        if ($from && $to) {
            $query->whereBetween('need_by_date', [$from, $to]);
        }
        $changeRequests = $query->get();

        // Calculate urgency counts
        $today = \Carbon\Carbon::today();
        $delayedCount = $changeRequests->filter(function($cr) use ($today) {
            return \Carbon\Carbon::parse($cr->need_by_date)->lt($today);
        })->count();

        $urgentCount = $changeRequests->filter(function($cr) use ($today) {
            $diff = $today->diffInDays(\Carbon\Carbon::parse($cr->need_by_date), false);
            return $diff >= 0 && $diff <= 10;
        })->count();

        $importantCount = $changeRequests->filter(function($cr) use ($today) {
            $diff = $today->diffInDays(\Carbon\Carbon::parse($cr->need_by_date), false);
            return $diff > 10 && $diff <= 20;
        })->count();

        $standardCount = $changeRequests->filter(function($cr) use ($today) {
            $diff = $today->diffInDays(\Carbon\Carbon::parse($cr->need_by_date), false);
            return $diff > 20;
        })->count();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', [
            'changeRequests' => $changeRequests,
            'from' => $from,
            'to' => $to,
            'delayedCount' => $delayedCount,
            'urgentCount' => $urgentCount,
            'importantCount' => $importantCount,
            'standardCount' => $standardCount,
        ]);

        return $pdf->download('ChangeRequestsReport_' . now()->format('Ymd_His') . '.pdf');
    }
}