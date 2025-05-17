<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Require authentication for all methods.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the home dashboard view.
     */
    public function index()
    {
        $user = Auth::user();
        //$crCount = ChangeRequest::count();
        return view('home', compact('user'));
        //return view('home', compact('crCount'));
    }
}
