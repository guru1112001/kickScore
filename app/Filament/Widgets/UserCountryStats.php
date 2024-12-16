<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class UserCountryStats extends BarChartWidget
{
    protected static ?string $heading = 'User vs Country';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = '2';

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Users',
            'active' => 'Active Users',
            'inactive' => 'Inactive Users',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $query = DB::table('users')
            ->select('countries.name as country', DB::raw('COUNT(*) as count'))
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->where('users.role_id', '=', 2)
            ->whereNull('users.deleted_at');

        if ($activeFilter === 'active') {
            $query->where('users.is_active', true);
        } elseif ($activeFilter === 'inactive') {
            $query->where('users.is_active', false);
        }

        $countryStats = $query->groupBy('countries.name')->get();

        $labels = $countryStats->pluck('country')->toArray();
        $data = $countryStats->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => $this->getLabelForFilter($activeFilter),
                    'data' => $data,
                    'backgroundColor' => $this->getBackgroundColorForFilter($activeFilter),
                    'borderColor' => $this->getBorderColorForFilter($activeFilter),
                    'borderWidth' => 2,
                    'barThickness' => 50,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'stepSize' => 1, // Show only integers
                        'beginAtZero' => true, // Start from zero
                        'precision' => 0, // Remove decimal places
                    ],
                ],
            ],
        ];
    }

    protected function getLabelForFilter(string $filter): string
    {
        return match ($filter) {
            'active' => 'Active Users',
            'inactive' => 'Inactive Users',
            default => 'All Users',
        };
    }

    protected function getBackgroundColorForFilter(string $filter): string
    {
        return match ($filter) {
            'active' => 'rgba(34, 197, 94, 0.6)',
            'inactive' => 'rgba(239, 68, 68, 0.6)',
            default => 'rgba(59, 130, 246, 0.6)',
        };
    }

    protected function getBorderColorForFilter(string $filter): string
    {
        return match ($filter) {
            'active' => 'rgba(34, 197, 94, 1)',
            'inactive' => 'rgba(239, 68, 68, 1)',
            default => 'rgba(59, 130, 246, 1)',
        };
    }
}
