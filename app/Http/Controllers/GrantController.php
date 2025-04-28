<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Grant;
use Illuminate\Http\Request;
use App\Models\Academician;

class GrantController extends Controller
{
    public function index()
    {
        // Load the leader relationship and any other related data if necessary
        $grants = Grant::with('leader')->get();  // Eager load the 'leader' relationship

        return view('grants.index', compact('grants'));
    }

    public function create()
    {
        // Get all academicians to display in the form dropdown
        $academicians = Academician::all();
        return view('grants.create', compact('academicians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grant_amount' => 'required|numeric',
            'grant_provider' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'project_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'duration' => 'required|numeric',
            'leader_id' => 'required|exists:academicians,id',  // Ensure leader_id is passed and valid
            'members' => 'nullable|array',  // Make members optional
            'members.*' => 'exists:academicians,id',  // Ensure each selected member exists
        ]);

        // Create a new grant
        $grant = Grant::create([
            'grant_amount' => $request->grant_amount,
            'grant_provider' => $request->grant_provider,
            'project_title' => $request->project_title,
            'project_description' => $request->project_description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->duration,
            'leader_id' => $request->leader_id,  // Add leader_id to the grant creation
            'members' => 'nullable|array',  // Make members optional
            'members.*' => 'exists:academicians,id',  // Ensure each selected member exists
        ]);

         // Attach the project leader to the grant
         $grant->academicians()->attach($request->leader_id, ['role' => 'leader']);

         // Attach the project members to the grant with role as member
         if ($request->has('members')) {
             foreach ($request->members as $member) {
                 $grant->academicians()->attach($member, ['role' => 'member']);
             }
         }
 
         // Redirect to the grants index page with a success message
         return redirect()->route('grants.index')->with('success', 'Grant created successfully.');
    }
    /*public function store(Request $request)
    {
        $request->validate([
            'grant_amount' => 'required|numeric',
            'grant_provider' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'project_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'duration' => 'required|numeric',
            'leader' => 'required|exists:academicians,id',
            'members' => 'nullable|array', // Make members optional
            'members.*' => 'exists:academicians,id',
        ]);

        // Create a new grant
        $grant = Grant::create([
            'grant_amount' => $request->grant_amount,
            'grant_provider' => $request->grant_provider,
            'project_title' => $request->project_title,
            'project_description' => $request->project_description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->duration,
        ]);

        // Attach the project leader to the grant
        $grant->academicians()->attach($request->leader, ['role' => 'leader']);

        // Attach the project members to the grant with role as member
        if ($request->has('members')) {
            foreach ($request->members as $member) {
                $grant->academicians()->attach($member, ['role' => 'member']);
            }
        }

        // Redirect to the grants index page with a success message
        return redirect()->route('grants.index')->with('success', 'Grant created successfully.');
    }*/

    public function show(Grant $grant)
    {
        // Fetch members and milestones
        $members = $grant->academicians()->wherePivot('role', 'member')->get();
        $milestones = $grant->milestones;

        // Check if the logged-in user is the leader or member
        $isLeader = $grant->leader_id == auth()->user()->academician_id;

        return view('grants.show', compact('grant', 'members', 'milestones', 'isLeader'));
    }

    /*

    public function show(Grant $grant)
    {
        // Get the project members for the grant
        $members = $grant->academicians()->wherePivot('role', 'member')->get(); // Get members associated with the grant
    
        // Get the milestones for the grant
        $milestones = $grant->milestones()->get();
    
        // Check if the logged-in user is the leader of the grant
        $isLeader = $grant->leader_id == auth()->user()->id;
    
        // Check if the logged-in user is a member of the grant
        $isMember = $grant->academicians->contains(auth()->user());
    
        // Pass the variables to the view
        return view('grants.show', compact('grant', 'members', 'milestones', 'isLeader', 'isMember'));
    }
    
     --before edit auth--
    public function show(Grant $grant)
    {
        $members = $grant->academicians()->wherePivot('role', 'member')->get();
        $milestones = $grant->milestones()->get();
        return view('grants.show', compact('grant', 'members', 'milestones'));
    }*/

    public function edit(Grant $grant)
    {
        /* Check if the logged-in user is the leader of the grant
        if (Gate::denies('isLeader', $grant)) {
            abort(403, 'You are not authorized to edit this grant');
        }*/ 

        // Get all academicians for the dropdown
        $academicians = Academician::all();  
        $members = $grant->academicians()->wherePivot('role', 'member')->get(); // Get project members
        return view('grants.edit', compact('grant', 'academicians', 'members'));
    }

     /* --before edit auth--
    public function edit(Grant $grant)
    {
        $academicians = Academician::all();  // Get all academicians for the dropdown
        $members = $grant->academicians()->wherePivot('role', 'member')->get(); // Get project members
        return view('grants.edit', compact('grant', 'academicians', 'members'));
    }*/

    public function update(Request $request, Grant $grant)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'grant_amount' => 'required|numeric',
            'grant_provider' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'project_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'duration' => 'required|numeric',
            'leader_id' => 'required|exists:academicians,id', // Ensure leader is selected
            'members' => 'nullable|array',  // Make members optional
            'members.*' => 'exists:academicians,id',  // Ensure each selected member exists
        ]);

        // Get the selected members
        $selectedMemberIds = $request->input('members', []);

        // Prepare sync data with roles
        $syncData = [];

        // Add the leader to the sync data (if a leader is selected)
        if ($request->has('leader_id') && $request->leader_id) {
            // Update the leader_id in the grant table
            $grant->leader_id = $request->leader_id;
            $syncData[$request->leader_id] = ['role' => 'leader']; // Sync leader
        }

        // Add members with 'member' role
        foreach ($selectedMemberIds as $memberId) {
            $syncData[$memberId] = ['role' => 'member'];  // Sync members
        }

        // Sync project members with roles
        $grant->academicians()->sync($syncData);

        // Update the grant record with validated data
        $grant->update($validatedData);

        // Redirect to the grants index page with a success message
        return redirect()->route('grants.index')->with('success', 'Grant updated successfully.');

        /*/ Get the selected members
        $selectedMemberIds = $request->input('members', []);

        // Prepare sync data with roles
        $syncData = [];

        // Add leader with 'leader' role
        $syncData[$request->leader] = ['role' => 'leader'];

        // Add members with 'member' role
        foreach ($selectedMemberIds as $memberId) {
            $syncData[$memberId] = ['role' => 'member'];
        }

        // Sync project members with roles
        $grant->academicians()->sync($syncData);

        // Update the grant record
        $grant->update($validatedData);

        // Redirect to the grants index page with a success message
        return redirect()->route('grants.index')->with('success', 'Grant updated successfully.');*/
    }

    public function destroy(Grant $grant)
    {
        $grant->delete();
        return redirect()->route('grants.index')->with('success', 'Grant deleted successfully.');
    }
}
