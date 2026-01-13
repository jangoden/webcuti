<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class LeaveRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Employee and Leave info in a grid layout
                Grid::make(2)
                    ->schema([
                        Section::make('Informasi Pegawai')
                            ->icon('heroicon-m-user-circle')
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Nama Pegawai')
                                    ->weight('semibold')
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('user.nip')
                                    ->label('NIP')
                                    ->copyable()
                                    ->icon('heroicon-m-identification'),
                                TextEntry::make('user.jabatan')
                                    ->label('Jabatan')
                                    ->icon('heroicon-m-briefcase'),
                                TextEntry::make('user.jenis_pegawai')
                                    ->label('Jenis Pegawai')
                                    ->badge()
                                    ->color('info'),
                            ])
                            ->columns(1),

                        Section::make('Detail Cuti')
                            ->icon('heroicon-m-calendar-days')
                            ->schema([
                                TextEntry::make('leaveType.name')
                                    ->label('Jenis Cuti')
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-m-tag'),
                                TextEntry::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->date('d M Y')
                                    ->icon('heroicon-m-calendar'),
                                TextEntry::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->date('d M Y')
                                    ->icon('heroicon-m-calendar'),
                                TextEntry::make('total_days')
                                    ->label('Lama Cuti')
                                    ->suffix(' hari')
                                    ->weight('semibold')
                                    ->icon('heroicon-m-clock')
                                    ->color('success'),
                            ])
                            ->columns(1),
                    ]),

                // Full-width sections below
                Section::make('Detail Pengajuan')
                    ->icon('heroicon-m-document-text')
                    ->schema([
                        TextEntry::make('reason')
                            ->label('Alasan Cuti')
                            ->placeholder('Tidak ada keterangan')
                            ->columnSpanFull(),
                        TextEntry::make('attachment')
                            ->label('File Pendukung')
                            ->placeholder('Tidak ada lampiran')
                            ->url(fn($record) => $record->attachment ? asset('storage/' . $record->attachment) : null)
                            ->openUrlInNewTab()
                            ->icon('heroicon-m-paper-clip')
                            ->color('info'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Status & Keputusan')
                    ->icon('heroicon-m-check-badge')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->size('lg')
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
                            })
                            ->icon(fn(string $state): string => match ($state) {
                                'pending' => 'heroicon-m-clock',
                                'approved' => 'heroicon-m-check-circle',
                                'rejected' => 'heroicon-m-x-circle',
                                default => 'heroicon-m-question-mark-circle',
                            }),
                        TextEntry::make('approvedBy.name')
                            ->label('Diproses Oleh')
                            ->placeholder('Belum diproses')
                            ->icon('heroicon-m-user'),
                        TextEntry::make('processed_at')
                            ->label('Tanggal Diproses')
                            ->dateTime('d M Y H:i')
                            ->placeholder('Belum diproses')
                            ->icon('heroicon-m-calendar-days'),
                        TextEntry::make('admin_notes')
                            ->label('Catatan Admin')
                            ->placeholder('Tidak ada catatan')
                            ->columnSpanFull()
                            ->icon('heroicon-m-chat-bubble-left-right'),
                    ])
                    ->columns(3),

                Section::make('Informasi Lainnya')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Tanggal Pengajuan')
                            ->dateTime('d M Y H:i')
                            ->icon('heroicon-m-calendar-days'),
                        TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d M Y H:i')
                            ->icon('heroicon-m-arrow-path'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
