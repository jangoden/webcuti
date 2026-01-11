<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyLeaveChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Cuti Per Bulan';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $year = now()->year;
        $months = [];
        $approvedData = [];
        $rejectedData = [];
        $pendingData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->translatedFormat('M');

            $approvedData[] = LeaveRequest::where('status', 'approved')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $i)
                ->count();

            $rejectedData[] = LeaveRequest::where('status', 'rejected')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $i)
                ->count();

            $pendingData[] = LeaveRequest::where('status', 'pending')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $i)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Disetujui',
                    'data' => $approvedData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Ditolak',
                    'data' => $rejectedData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.8)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
                [
                    'label' => 'Menunggu',
                    'data' => $pendingData,
                    'backgroundColor' => 'rgba(234, 179, 8, 0.8)',
                    'borderColor' => 'rgb(234, 179, 8)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
