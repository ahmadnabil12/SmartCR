<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChangeRequest;
use App\Models\User;
use App\Notifications\NewCRAssigned;

class ChangeRequestController extends Controller
{
    // Requestor views their CRs
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1) build your “base” query depending on role:
        $query = match($user->role) {
            'implementor' => ChangeRequest::where('implementor_id', $user->id),
            'requestor'   => ChangeRequest::where('requestor_id', $user->id),
            'hou'         => ChangeRequest::where('unit', $user->unit),
            default       => ChangeRequest::query(),
        };

        // 2) if the user passed ?q=foo, add a WHERE title LIKE '%foo%'
        if ($request->filled('q')) {
            $searchTerm = '%'.$request->q.'%';
            $query->where('title', 'like', $searchTerm);
        }

        // 3) finally execute
        $changeRequests = $query->get();

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
        $user = auth()->user();

        // Requestor can only edit if their own CR and status is 'Requirement Gathering'
        if ($user->role === 'requestor') {
            if ($changeRequest->requestor_id !== $user->id || $changeRequest->status !== 'Requirement Gathering') {
                return redirect()->route('change-requests.index')
                    ->with('error', 'You can only edit your own CR during Requirement Gathering.');
            }
        }
        // Optionally: restrict others if you want

        return view('change_requests.edit', compact('changeRequest', 'user'));
    }

    public function update(Request $request, ChangeRequest $changeRequest)
    {
        $user = auth()->user();

        if ($user->role === 'requestor') {
            // Only allow if status is Requirement Gathering
            if ($changeRequest->status !== 'Requirement Gathering') {
                return redirect()->route('change-requests.index')
                    ->with('error', 'You can only update during Requirement Gathering.');
            }

            // Validate only requestor fields
            $request->validate([
                'title' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'need_by_date' => 'required|date',
                'comment' => 'nullable|string',
            ]);

            $changeRequest->update($request->only('title', 'unit', 'need_by_date', 'comment'));

        } else if (in_array($user->role, ['implementor', 'hou', 'hod', 'admin'])) {
            // Validate implementor/admin fields
            $request->validate([
                'status' => 'required|string',
                'complexity' => 'required|string|in:Low,Medium,High',
                'comment' => 'nullable|string',
            ]);

            $changeRequest->update($request->only('status', 'complexity', 'comment'));
        }

        return redirect()->route('change-requests.index')->with('success', 'CR updated successfully.');
    }

    public function destroy(ChangeRequest $changeRequest)
    {
        if (auth()->user()->role === 'requestor' && $changeRequest->status !== 'Requirement Gathering') {
            return redirect()->route('change-requests.index')
                ->with('error', 'You can only delete during Requirement Gathering.');
        }

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

    public function pending()
    {
        $user = auth()->user();
        $query = match($user->role) {
            'requestor'    => ChangeRequest::where('requestor_id', $user->id),
            'implementor'  => ChangeRequest::where('implementor_id', $user->id),
            'hou'          => ChangeRequest::where('unit', $user->unit),
            default        => ChangeRequest::query(),
        };

        $changeRequests = $query->where('status', '!=', 'Completed')->get();
        return view('change_requests.index', compact('changeRequests'));
    }

    public function completed()
    {
        $user = auth()->user();
        $query = match($user->role) {
            'requestor'    => ChangeRequest::where('requestor_id', $user->id),
            'implementor'  => ChangeRequest::where('implementor_id', $user->id),
            'hou'          => ChangeRequest::where('unit', $user->unit),
            default        => ChangeRequest::query(),
        };

        $changeRequests = $query->where('status', 'Completed')->get();
        return view('change_requests.index', compact('changeRequests'));
    }
}
