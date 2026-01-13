<?php

namespace App\Filament\Pages\RekapCuti\Widgets;

use App\Services\LeaveReportService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class RekapCutiStats extends BaseWidget
{
    public ?string $periodType = 'monthly';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?int $selectedYear = null;
    public ?int $selectedMonth = null;

    protected function getStats(): array
    {
        // Resolve Service manually since Widgets don't auto-inject in mount easily
        $service = app(LeaveReportService::class);

        // Determine dates based on props passed from Page
        $data = match ($this->periodType) {
            'weekly' => $service->getWeeklyReport($this->startDate, $this->endDate),
            'monthly' => $service->getMonthlyReport($this->selectedYear, $this->selectedMonth),
            'yearly' => $service->getYearlyReport($this->selectedYear),
            default => collect([]),
        };

        $stats = $service->calculateStatistics($data);

        return [
            Stat::make('Total Pegawai', $stats['total_employees'])
                ->icon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Pengajuan', $stats['total_requests'])
                ->icon('heroicon-m-document-text')
                ->color('info'),
            Stat::make('Disetujui', $stats['total_approved'])
                ->icon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Total Hari Cuti', $stats['total_leave_days'])
                ->icon('heroicon-m-calendar-days')
                ->color('gray'),
            Stat::make('Menunggu', $stats['total_pending'])
                ->icon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Ditolak', $stats['total_rejected'])
                ->icon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}