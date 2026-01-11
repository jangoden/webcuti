<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        $totalPegawai = User::where('role', 'pegawai')->count();
        $pendingRequests = LeaveRequest::where('status', 'pending')->count();
        $approvedThisMonth = LeaveRequest::where('status', 'approved')
            ->whereMonth('processed_at', now()->month)
            ->whereYear('processed_at', now()->year)
            ->count();
        $rejectedThisMonth = LeaveRequest::where('status', 'rejected')
            ->whereMonth('processed_at', now()->month)
            ->whereYear('processed_at', now()->year)
            ->count();

        return [
            Stat::make('Total Pegawai', $totalPegawai)
                ->description('Jumlah pegawai terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Menunggu Persetujuan', $pendingRequests)
                ->description('Pengajuan yang belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Disetujui Bulan Ini', $approvedThisMonth)
                ->description('Cuti yang disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Ditolak Bulan Ini', $rejectedThisMonth)
                ->description('Cuti yang ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
