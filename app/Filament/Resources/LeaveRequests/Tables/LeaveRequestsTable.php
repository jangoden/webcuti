<?php

namespace App\Filament\Resources\LeaveRequests\Tables;

use App\Models\LeaveRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class LeaveRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.nip')
                    ->label('NIP')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('leaveType.name')
                    ->label('Jenis Cuti')
                    ->searchable()
                    ->badge(),
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('total_days')
                    ->label('Lama Cuti')
                    ->suffix(' hari')
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
                SelectFilter::make('leave_type_id')
                    ->label('Jenis Cuti')
                    ->relationship('leaveType', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Pengajuan Cuti')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui pengajuan cuti ini?')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Catatan Admin')
                            ->placeholder('Opsional - tambahkan catatan jika diperlukan'),
                    ])
                    ->action(function (LeaveRequest $record, array $data): void {
                        $record->update([
                            'status' => 'approved',
                            'admin_notes' => $data['admin_notes'] ?? null,
                            'approved_by' => auth()->id(),
                            'processed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pengajuan cuti disetujui')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(LeaveRequest $record): bool => $record->isPending()),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengajuan Cuti')
                    ->modalDescription('Apakah Anda yakin ingin menolak pengajuan cuti ini?')
                    ->modalSubmitActionLabel('Ya, Tolak')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Berikan alasan penolakan'),
                    ])
                    ->action(function (LeaveRequest $record, array $data): void {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'approved_by' => auth()->id(),
                            'processed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pengajuan cuti ditolak')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(LeaveRequest $record): bool => $record->isPending()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkApprove')
                        ->label('Setujui yang Dipilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function (LeaveRequest $record): void {
                                if ($record->isPending()) {
                                    $record->update([
                                        'status' => 'approved',
                                        'approved_by' => auth()->id(),
                                        'processed_at' => now(),
                                    ]);
                                }
                            });

                            Notification::make()
                                ->title('Pengajuan cuti disetujui')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('bulkReject')
                        ->label('Tolak yang Dipilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            Textarea::make('admin_notes')
                                ->label('Alasan Penolakan')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function (LeaveRequest $record) use ($data): void {
                                if ($record->isPending()) {
                                    $record->update([
                                        'status' => 'rejected',
                                        'admin_notes' => $data['admin_notes'],
                                        'approved_by' => auth()->id(),
                                        'processed_at' => now(),
                                    ]);
                                }
                            });

                            Notification::make()
                                ->title('Pengajuan cuti ditolak')
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
