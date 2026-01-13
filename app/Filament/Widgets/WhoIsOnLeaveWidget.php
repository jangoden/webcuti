<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class WhoIsOnLeaveWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected static ?string $heading = 'Sedang Cuti Hari Ini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LeaveRequest::query()
                    ->where('status', 'approved')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->description(fn (LeaveRequest $record) => $record->user->jabatan ?? 'Pegawai')
                    ->wrap()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Sampai')
                    ->date('d M Y')
                    ->badge()
                    ->alignCenter()
                    ->color('success'),
            ])
            ->paginated(false)
            ->emptyStateHeading('Tidak ada pegawai cuti hari ini');
    }
}
