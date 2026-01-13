<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getColumns(): int
    {
        return 6;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pegawai', User::where('role', 'pegawai')->count())
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Pengajuan', LeaveRequest::count())
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Disetujui', LeaveRequest::where('status', 'approved')->count())
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Hari Cuti', LeaveRequest::where('status', 'approved')->sum('total_days'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Menunggu Persetujuan', LeaveRequest::where('status', 'pending')->count())
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Ditolak', LeaveRequest::where('status', 'rejected')->count())
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
