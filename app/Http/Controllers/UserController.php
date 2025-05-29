<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show all users (admin only)
    public function index(Request $request)
    {
        $query = User::query();

        // 1. keep the role filter you already have
        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        // 2. new: apply a name/email search
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. paginate (or ->get())
        $users = $query->paginate(20)
                    ->appends($request->only(['role','search']));

        return view('users.index', compact('users'));
    }

    // Show form to create new user
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:requestor,implementor,hou,hod',
            'password' => 'required|string|min:8',
            'unit' => $request->role === 'hou' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'unit' => $request->role === 'hou' ? $request->unit : null,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    // Show user profile (optional)
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Show edit form
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:requestor,implementor,hou,hod',
            'unit' => $request->role === 'hou' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'unit' => $request->role === 'hou' ? $request->unit : null,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // Restrict access to admin users only
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
}
