<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\LeaveRequestController;
use App\Http\Controllers\Employee\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root based on auth status and role
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/admin');
        } elseif ($user->isPegawai()) {
            return redirect()->route('pegawai.dashboard');
        }
    }

    return redirect()->route('login');
});

// Guest Routes (Unauthenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (Authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Employee Routes (Pegawai only)
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/cuti/ajukan', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/cuti', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::get('/cuti/riwayat', [LeaveRequestController::class, 'index'])->name('leave.history');
    Route::get('/cuti/export-pdf', [LeaveRequestController::class, 'exportPdf'])->name('leave.export');
});
