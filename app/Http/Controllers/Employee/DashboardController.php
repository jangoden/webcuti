<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the employee dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Get leave statistics
        $jatahCuti = $user->jumlah_cuti;
        $sisaCuti = $user->getRemainingLeave();
        $cutiTerpakai = $user->getUsedLeave();

        // Get last leave request
        $lastLeaveRequest = $user->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->first();

        // Get pending leave requests count
        $pendingCount = $user->leaveRequests()
            ->where('status', 'pending')
            ->count();

        return view('employee.dashboard', compact(
            'user',
            'jatahCuti',
            'sisaCuti',
            'cutiTerpakai',
            'lastLeaveRequest',
            'pendingCount'
        ));
    }
}
