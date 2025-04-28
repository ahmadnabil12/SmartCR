<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Grant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Grant $grant)
    {

        $grants = Grant::whereHas('academicians', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where(function ($query) {
                      $query->where('role', 'like', '%member%')
                            ->orWhere('role', 'like', '%leader%');
                  });
        })->get();

        $milestones = Milestone::all();
        //$milestones = $grant->milestones;  // Retrieve milestones associated with the given grant
        return view('milestones.index', compact('milestones', 'grant'));  // Pass to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grants = Grant::all();
        return view('milestones.create', compact('grants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        
        $validatedData = $request->validate([
            'milestone_title' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'deliverable' => 'required|string',
            'status' => 'required|string',
            'remark' => 'required|string',
            'grant_id' => 'required|exists:grants,id',
        ]);

        Milestone::create($validatedData);

        return redirect()->route('milestones.index')->with('success', 'Milestone updated successfully.');
        //return redirect()->back()->with('success', 'Milestone created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Milestone $milestone)
    {
        return view('milestones.show', compact('milestone'));  // Pass milestone to the 'show' view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Milestone $milestone)
    {
        $grants = Grant::all();
        return view('milestones.edit', compact('milestone', 'grants'));  // Pass milestone to the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'milestone_title' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'deliverable' => 'required|string',
            'status' => 'required|string|max:255',
            'remark' => 'required|string',  // Make remark optional
            'grant_id' => 'required|exists:grants,id',
            //'date_updated' => 'required|date',  // Ensure date_updated is provided
        ]);

        // Update the milestone record with the new data
        $milestone->update([
            'milestone_title' => $validatedData['milestone_title'],
            'completion_date' => $validatedData['completion_date'],
            'deliverable' => $validatedData['deliverable'],
            'status' => $validatedData['status'],
            'remark' => $validatedData['remark'] ?? 'No comments provided',  // Default if no remark is given
            'grant_id' => $validatedData['grant_id'],
            //'date_updated' => $validatedData['date_updated'],
        ]);

        // Redirect to the milestones index with success message
        return redirect()->route('milestones.index', $milestone->grant_id)->with('success', 'Milestone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();  // Delete the milestone record from the database

        // Redirect to the milestones index with success message
        return redirect()->route('milestones.index', $milestone->grant_id)->with('success', 'Milestone deleted successfully.');
    }
}
