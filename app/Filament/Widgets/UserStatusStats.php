<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserStatusStats extends BaseWidget
{
    protected function getStats(): array
    {
        $activeUsers = User::where('is_active', 1)->where('role_id',2)->count();
        $nonActiveUsers = User::where('is_active', 0)->where('role_id',2)->count();
        $allUsers=User::where('role_id',2)->count();

        return [
            Stat::make('All Users', $allUsers)
                ->description('All Users ')
                ->color('info'),
            Stat::make('Active Users', $activeUsers)
                ->description('Users currently active')
                ->color('success'),
            Stat::make('Non-Active Users', $nonActiveUsers)
                ->description('Users not active')
                ->color('danger'),
        ];
    }
}
