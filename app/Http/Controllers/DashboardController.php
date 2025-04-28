<?php

namespace App\Http\Controllers;

use App\Models\Academician;
use App\Models\Grant;
use App\Models\Milestone;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get counts of Academicians, Grants, and Milestones
        $academiciansCount = Academician::count();
        $grantsCount = Grant::count();
        $milestonesCount = Milestone::count();

        // Pass counts to the view
        return view('dashboard', compact('academiciansCount', 'grantsCount', 'milestonesCount'));
    }
}
