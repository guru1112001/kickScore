<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class UserCountryStats extends BarChartWidget
{
    protected static ?string $heading = 'User vs Country';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = '2';

    // Set a default filter value
    public ?string $filter = 'all';

    // Define the filter options
    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Users',
            'active' => 'Active Users',
            'inactive' => 'Inactive Users',
        ];
    }

    // Fetch data based on the active filter
    protected function getData(): array
    {
        $activeFilter = $this->filter; // Get the active filter value

        // Build the query
        $query = DB::table('users')
            ->select('countries.name as country', DB::raw('COUNT(*) as count'))
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->whereNull('users.deleted_at');

        // Apply filter condition
        if ($activeFilter === 'active') {
            $query->where('users.is_active', true);
        } elseif ($activeFilter === 'inactive') {
            $query->where('users.is_active', false);
        }

        // Fetch data
        $countryStats = $query->groupBy('countries.name')->get();

        // Extract labels (country names) and data (user counts)
        $labels = $countryStats->pluck('country')->toArray();
        $data = $countryStats->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => $this->getLabelForFilter($activeFilter),
                    'data' => $data,
                    'backgroundColor' => 'linear-gradient(to right, #8a2be2, #4169e1)', // Gradient color
                    'borderColor' => '#1e3a8a', // Border color
                    'borderWidth' => 2, // Border thickness
                    'barThickness' => 50, // Bar thickness
                ],
            ],
            'labels' => $labels, // Country names
        ];
    }

    // Helper method to get the chart label based on the filter
    protected function getLabelForFilter(string $filter): string
    {
        return match ($filter) {
            'active' => 'Active Users',
            'inactive' => 'Inactive Users',
            default => 'All Users',
        };
    }
}
