<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LeaveRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pegawai')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Nama Pegawai'),
                        TextEntry::make('user.nip')
                            ->label('NIP'),
                        TextEntry::make('user.jabatan')
                            ->label('Jabatan'),
                        TextEntry::make('user.jenis_pegawai')
                            ->label('Jenis Pegawai')
                            ->badge(),
                    ])
                    ->columns(2),

                Section::make('Detail Cuti')
                    ->schema([
                        TextEntry::make('leaveType.name')
                            ->label('Jenis Cuti')
                            ->badge(),
                        TextEntry::make('start_date')
                            ->label('Tanggal Mulai')
                            ->date('d M Y'),
                        TextEntry::make('end_date')
                            ->label('Tanggal Selesai')
                            ->date('d M Y'),
                        TextEntry::make('total_days')
                            ->label('Lama Cuti')
                            ->suffix(' hari'),
                        TextEntry::make('reason')
                            ->label('Alasan Cuti')
                            ->placeholder('Tidak ada keterangan')
                            ->columnSpanFull(),
                        TextEntry::make('attachment')
                            ->label('File Pendukung')
                            ->placeholder('Tidak ada lampiran')
                            ->url(fn($record) => $record->attachment ? asset('storage/' . $record->attachment) : null)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2),

                Section::make('Status & Keputusan')
                    ->schema([
                        TextEntry::make('status')
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
                        TextEntry::make('approvedBy.name')
                            ->label('Diproses Oleh')
                            ->placeholder('Belum diproses'),
                        TextEntry::make('processed_at')
                            ->label('Tanggal Diproses')
                            ->dateTime('d M Y H:i')
                            ->placeholder('Belum diproses'),
                        TextEntry::make('admin_notes')
                            ->label('Catatan Admin')
                            ->placeholder('Tidak ada catatan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Informasi Lainnya')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Tanggal Pengajuan')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
