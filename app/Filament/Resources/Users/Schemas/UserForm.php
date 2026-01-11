<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pribadi')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nip')
                            ->label('NIP')
                            ->unique(ignoreRecord: true)
                            ->maxLength(18),
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->maxLength(255),
                        Select::make('jenis_pegawai')
                            ->label('Jenis Pegawai')
                            ->options([
                                'ASN' => 'ASN',
                                'NON ASN' => 'NON ASN',
                                'PPPK' => 'PPPK',
                            ]),
                    ])
                    ->columns(2),

                Section::make('Akun Login')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('username')
                            ->label('Username')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Pengaturan Cuti & Role')
                    ->schema([
                        TextInput::make('jumlah_cuti')
                            ->label('Jatah Cuti Tahunan')
                            ->required()
                            ->numeric()
                            ->default(12)
                            ->minValue(0)
                            ->maxValue(365),
                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'pegawai' => 'Pegawai',
                            ])
                            ->default('pegawai')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
