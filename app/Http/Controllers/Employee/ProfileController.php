<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the employee profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('employee.profile', compact('user'));
    }
}
