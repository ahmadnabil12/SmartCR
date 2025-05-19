<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ChangeRequest;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'requestor') {
            $crCount = ChangeRequest::where('requestor_id', $user->id)->count();
            $label = 'Your Submitted CRs';
        } elseif ($user->role === 'implementor') {
            $crCount = ChangeRequest::where('implementor_id', $user->id)->count();
            $label = 'Assigned CRs';
        } elseif ($user->role === 'hou') {
            $crCount = ChangeRequest::where('unit', $user->unit)->count();
            $label = 'Unit CRs (' . $user->unit . ')';
        } else {
            $crCount = ChangeRequest::count(); // total
            $label = 'Total Change Requests';
        }

        return view('dashboard', compact('crCount', 'label'));
    }

}
