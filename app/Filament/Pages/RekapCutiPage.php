<?php

namespace App\Filament\Pages;

use App\Services\LeaveReportService;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Url;
use App\Filament\Pages\RekapCuti\Widgets\RekapCutiStats;

class RekapCutiPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected string $view = 'filament.pages.rekap-cuti';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document-chart-bar';
    }

    public static function getNavigationLabel(): string
    {
        return 'Rekap Cuti';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public function getTitle(): string
    {
        return 'Rekap Cuti';
    }

    #[Url]
    public string $periodType = 'monthly';

    #[Url]
    public ?string $startDate = null;

    #[Url]
    public ?string $endDate = null;

    #[Url]
    public ?int $selectedYear = null;

    #[Url]
    public ?int $selectedMonth = null;

    protected LeaveReportService $reportService;

    public function boot(LeaveReportService $reportService): void
    {
        $this->reportService = $reportService;
    }

    public function mount(): void
    {
        // Initialize defaults
        $this->selectedYear = $this->selectedYear ?? now()->year;
        $this->selectedMonth = $this->selectedMonth ?? now()->month;
        $this->startDate = $this->startDate ?? now()->startOfWeek()->toDateString();
        $this->endDate = $this->endDate ?? now()->endOfWeek()->toDateString();
        
        // Fill the form with current property values
        $this->form->fill([
            'periodType' => $this->periodType,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'selectedYear' => $this->selectedYear,
            'selectedMonth' => $this->selectedMonth,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('periodType')
                    ->label('Periode')
                    ->options([
                        'weekly' => 'Mingguan',
                        'monthly' => 'Bulanan',
                        'yearly' => 'Tahunan',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn () => $this->updatePeriodDefaults())
                    ->columnSpan(1),

                DatePicker::make('startDate')
                    ->label('Tanggal Mulai')
                    ->visible(fn () => $this->periodType === 'weekly')
                    ->required(fn () => $this->periodType === 'weekly')
                    ->columnSpan(1),

                DatePicker::make('endDate')
                    ->label('Tanggal Selesai')
                    ->visible(fn () => $this->periodType === 'weekly')
                    ->required(fn () => $this->periodType === 'weekly')
                    ->after('startDate')
                    ->columnSpan(1),

                Select::make('selectedMonth')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ])
                    ->visible(fn () => $this->periodType === 'monthly')
                    ->required(fn () => $this->periodType === 'monthly')
                    ->columnSpan(1),

                Select::make('selectedYear')
                    ->label('Tahun')
                    ->options(function () {
                        $years = [];
                        for ($i = now()->year - 5; $i <= now()->year + 1; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->visible(fn () => in_array($this->periodType, ['monthly', 'yearly']))
                    ->required(fn () => in_array($this->periodType, ['monthly', 'yearly']))
                    ->columnSpan(1),
            ])
            ->columns(3);
            // Removed statePath('data') to bind directly to properties
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                // Calculate dates INSIDE the query closure to ensure fresh values on every refresh
                $startDate = $this->startDate;
                $endDate = $this->endDate;

                if ($this->periodType === 'monthly') {
                    $startDate = now()->create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
                    $endDate = now()->create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth();
                } elseif ($this->periodType === 'yearly') {
                    $startDate = now()->create($this->selectedYear, 1, 1)->startOfYear();
                    $endDate = now()->create($this->selectedYear, 12, 31)->endOfYear();
                }

                return \App\Models\User::query()
                    ->where('role', 'pegawai')
                    ->withSum(['leaveRequests as total_days' => fn($q) => $q->where('status', 'approved')->whereBetween('created_at', [$startDate, $endDate])], 'total_days')
                    ->withCount(['leaveRequests as total_requests' => fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])])
                    ->withCount(['leaveRequests as approved' => fn($q) => $q->where('status', 'approved')->whereBetween('created_at', [$startDate, $endDate])])
                    ->withCount(['leaveRequests as pending' => fn($q) => $q->where('status', 'pending')->whereBetween('created_at', [$startDate, $endDate])])
                    ->withCount(['leaveRequests as rejected' => fn($q) => $q->where('status', 'rejected')->whereBetween('created_at', [$startDate, $endDate])]);
            })
            ->columns([
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label('Pegawai')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->jabatan)
                    ->weight('bold'),
                TextColumn::make('total_requests')
                    ->label('Total')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('approved')
                    ->label('Disetujui')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('pending')
                    ->label('Menunggu')
                    ->alignCenter()
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('rejected')
                    ->label('Ditolak')
                    ->alignCenter()
                    ->badge()
                    ->color('danger')
                    ->sortable(),
                TextColumn::make('total_days')
                    ->label('Hari Cuti')
                    ->alignCenter()
                    ->suffix(' Hari')
                    ->placeholder('0')
                    ->weight('bold')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50, 'all']);
    }

    protected function updatePeriodDefaults(): void
    {
        if ($this->periodType === 'weekly') {
            $this->startDate = now()->startOfWeek()->toDateString();
            $this->endDate = now()->endOfWeek()->toDateString();
        } elseif ($this->periodType === 'monthly') {
            $this->selectedMonth = now()->month;
            $this->selectedYear = now()->year;
        } else {
            $this->selectedYear = now()->year;
        }
    }

    public function getReportData()
    {
        // Helper for PDF export only now, table uses query builder directly
        return match ($this->periodType) {
            'weekly' => $this->reportService->getWeeklyReport($this->startDate, $this->endDate),
            'monthly' => $this->reportService->getMonthlyReport($this->selectedYear, $this->selectedMonth),
            'yearly' => $this->reportService->getYearlyReport($this->selectedYear),
            default => collect([]),
        };
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action('exportToPdf'),
        ];
    }

    public function exportToPdf()
    {
        $data = $this->getReportData();
        $statistics = $this->reportService->calculateStatistics($data);

        $periodLabel = match ($this->periodType) {
            'weekly' => "Mingguan ({$this->startDate} - {$this->endDate})",
            'monthly' => now()->create($this->selectedYear, $this->selectedMonth)->locale('id')->translatedFormat('F Y'),
            'yearly' => "Tahunan {$this->selectedYear}",
        };

        $pdf = Pdf::loadView('pdf.rekap-cuti', [
            'data' => $data,
            'statistics' => $statistics,
            'periodType' => $this->periodType,
            'periodLabel' => $periodLabel,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'rekap-cuti-' . now()->format('Y-m-d') . '.pdf');
    }
}