<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCRAssigned;

class ChangeRequestController extends Controller
{
    // Requestor views their CRs
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'implementor') {
            $changeRequests = ChangeRequest::where('implementor_id', $user->id)->get();
        } elseif ($user->role === 'requestor') {
            $changeRequests = ChangeRequest::where('requestor_id', $user->id)->get();
        } elseif ($user->role === 'hou') {
            $changeRequests = ChangeRequest::where('unit', $user->unit)->get();
        } else {
            // For HOU, HOD, or Admins — show all
            $changeRequests = ChangeRequest::all();
        }

        return view('change_requests.index', compact('changeRequests'));
    }

    // Form to create CR
    public function create()
    {
        $implementors = User::where('role', 'implementor')->get(); // dropdown
        return view('change_requests.create', compact('implementors'));
    }

    // Store new CR
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
            'need_by_date' => 'required|date',
            'comment' => 'nullable|string',
            'implementor_id' => 'required|exists:users,id',
        ]);

        $cr = ChangeRequest::create([
            'title' => $request->title,
            'unit' => $request->unit,
            'need_by_date' => $request->need_by_date,
            'status' => 'Requirement Gathering',
            'complexity' => null,
            'comment' => $request->comment,
            'requestor_id' => Auth::id(),
            'implementor_id' => $request->implementor_id,
        ]);

        // Notify the implementor by email
        $implementor = User::find($request->implementor_id);
        if ($implementor) {
            $implementor->notify(new NewCRAssigned($cr));
        }

        return redirect()->route('change-requests.index')->with('success', 'CR submitted and implementor notified.');
    }

    // Show single CR
    public function show(ChangeRequest $changeRequest)
    {
        return view('change_requests.show', compact('changeRequest'));
    }

    // Edit CR (for implementor to update status/complexity)
    public function edit(ChangeRequest $changeRequest)
    {
        return view('change_requests.edit', compact('changeRequest'));
    }

    public function update(Request $request, ChangeRequest $changeRequest)
    {
        $request->validate([
            'status' => 'required|string',
            'complexity' => 'required|string|in:Low,Medium,High',
            'comment' => 'nullable|string',
        ]);

        $changeRequest->update([
            'status' => $request->status,
            'complexity' => $request->complexity,
            'comment' => $request->comment,
        ]);

        return redirect()->route('change-requests.index')->with('success', 'CR updated successfully.');
    }

    public function destroy(ChangeRequest $changeRequest)
    {
        $changeRequest->delete();
        return back()->with('success', 'CR deleted.');
    }

    // Optional: View own CRs (can be used for implementor too)
    public function myCRs()
    {
        $user = Auth::user();
        if ($user->userCategory == 'implementor') {
            $changeRequests = ChangeRequest::where('implementor_id', $user->id)->get();
        } else {
            $changeRequests = ChangeRequest::where('requestor_id', $user->id)->get();
        }

        return view('change_requests.my', compact('changeRequests'));
    }
}
