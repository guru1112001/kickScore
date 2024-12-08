<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserStatusStats extends BaseWidget
{
    protected function getStats(): array
    {
        $activeUsers = User::where('is_active', 1)->count();
        $nonActiveUsers = User::where('is_active', 0)->count();
        $allUsers=User::count();

        return [
            Stat::make('Register Users', $allUsers)
                ->description('All register Users ')
                ->color('danger'),
            Stat::make('Active Users', $activeUsers)
                ->description('Users currently active')
                ->color('success'),
            Stat::make('Non-Active Users', $nonActiveUsers)
                ->description('Users not active')
                ->color('danger'),
        ];
    }
}
