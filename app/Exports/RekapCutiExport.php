<?php

namespace App\Exports;

use App\Services\LeaveReportService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapCutiExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    protected string $periodType;
    protected ?string $startDate;
    protected ?string $endDate;
    protected ?int $selectedYear;
    protected ?int $selectedMonth;
    protected LeaveReportService $reportService;

    public function __construct(
        string $periodType,
        ?string $startDate,
        ?string $endDate,
        ?int $selectedYear,
        ?int $selectedMonth
    ) {
        $this->periodType = $periodType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedYear = $selectedYear;
        $this->selectedMonth = $selectedMonth;
        
        // Use resolve to get the service, as we can't easily inject into constructor when creating manually
        $this->reportService = resolve(LeaveReportService::class);
    }

    public function view(): View
    {
        $data = $this->getReportData();
        $statistics = $this->reportService->calculateStatistics($data);

        $periodLabel = match ($this->periodType) {
            'weekly' => "Mingguan ({$this->startDate} - {$this->endDate})",
            'monthly' => now()->create($this->selectedYear, $this->selectedMonth)->locale('id')->translatedFormat('F Y'),
            'yearly' => "Tahunan {$this->selectedYear}",
            default => '-',
        };

        return view('excel.rekap-cuti', [
            'data' => $data,
            'statistics' => $statistics,
            'periodLabel' => $periodLabel,
        ]);
    }

    protected function getReportData()
    {
        return match ($this->periodType) {
            'weekly' => $this->reportService->getWeeklyReport($this->startDate, $this->endDate),
            'monthly' => $this->reportService->getMonthlyReport($this->selectedYear, $this->selectedMonth),
            'yearly' => $this->reportService->getYearlyReport($this->selectedYear),
            default => collect([]),
        };
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,  // No
            'B' => 20, // NIP
            'C' => 30, // Nama Pegawai
            'D' => 25, // Jabatan
            'E' => 15, // Total Request
            'F' => 15, // Disetujui
            'G' => 15, // Menunggu
            'H' => 15, // Ditolak
            'I' => 15, // Total Hari Cuti
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Title
            1 => ['font' => ['bold' => true, 'size' => 16]],
            // Period
            2 => ['font' => ['size' => 12]],
            // Summary Headers
            4 => ['font' => ['bold' => true]],
            // Table Headers
            7 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'], // Indigo-600
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
            // Data Rows (Starting from row 8)
            // We can't easily target all data rows dynamically here without knowing count, 
            // but we can set default alignment for specific columns if needed.
        ];
    }
}
