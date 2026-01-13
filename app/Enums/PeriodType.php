<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PeriodType: string implements HasLabel
{
    case Weekly = 'weekly';
    case Monthly = 'monthly';
    case Yearly = 'yearly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Weekly => 'Mingguan',
            self::Monthly => 'Bulanan',
            self::Yearly => 'Tahunan',
        };
    }
}
