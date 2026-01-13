<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.welcome-widget';

    protected static ?int $sort = -5;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 3,
    ];
}