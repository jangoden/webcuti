<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LeaveRequests\LeaveRequestResource;
use App\Models\LeaveRequest;
use Filament\Tables;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeaveRequestsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 2,
    ];

    protected static ?string $heading = 'Pengajuan Cuti Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LeaveRequest::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->description(fn (LeaveRequest $record) => $record->user->nip)
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('leaveType.name')
                    ->label('Jenis Cuti')
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->description(fn (LeaveRequest $record) => 's/d ' . $record->end_date->format('d M Y'))
                    ->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (LeaveRequest $record) => LeaveRequestResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false)
            ->defaultPaginationPageOption(5);
    }
}
