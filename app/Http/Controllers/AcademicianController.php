<?php

namespace App\Http\Controllers;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Http\Request;

class AcademicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicians = Academician::all();  // Retrieve all academicians from the database
        return view('academicians.index', compact('academicians'));  // Pass to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academicians.create');  // Return the 'create' view for academicians
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'staff_number' => 'required|string|max:255|unique:academicians',
            'email' => 'required|email|unique:academicians',
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'), // Hash the password
            'userCategory' => 'academician',  
        ]); 

        $academician = Academician::create([
            'name' => $request->name,
            'staff_number' => $request->staff_number,
            'email' => $request->email,
            'college' => $request->college,
            'department' => $request->department,
            'position' => $request->position,
            'user_id' => $user->id,  // Link the user to the academician
        ]);

        // Create new academician record
        //Academician::create($validatedData);  // Use mass assignment

        return redirect()->route('academicians.index')->with('success', 'Academician created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Academician $academician)
    {
        return view('academicians.show', compact('academician'));  // Pass academician to the 'show' view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Academician $academician)
    {
        return view('academicians.edit', compact('academician'));  // Pass academician to the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Academician $academician)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'staff_number' => 'required|string|max:255|unique:academicians,staff_number,' . $academician->id,
            'email' => 'required|email|unique:academicians,email,' . $academician->id,
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        // Update the academician record
        $academician->update($validatedData);

        return redirect()->route('academicians.index')->with('success', 'Academician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academician $academician)
    {
        $academician->delete();  // Delete the academician record from the database

        return redirect()->route('academicians.index')->with('success', 'Academician deleted successfully.');
    }
}
