<?php
namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class UserCountryStats extends BarChartWidget
{
    protected static ?string $heading = 'User vs Country';
    protected static ?int $sort = 2;
    protected int | string | array  $columnSpan = '2';

    protected function getData(): array
    {
        // Fetching the number of users per country
        $countryStats = DB::table('users')
            ->select('countries.name as country', DB::raw('COUNT(*) as count'))
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->whereNull('users.deleted_at')
            ->groupBy('countries.name')
            ->get();

        // Extracting labels (country names) and data (user counts)
        $labels = $countryStats->pluck('country')->toArray();
        $data = $countryStats->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Users',
                    'data' => $data,
                    // 'backgroundColor' => '#42a5f5', // Bar color
                    'backgroundColor'=>'linear-gradient(to right, #8a2be2, #4169e1)',
                    'borderColor' => '#1e3a8a', // Change this to your desired border color (e.g., navy blue)
                    'borderWidth' => 2, // Border thickness
                    'barThickness'=>50
                ],
            ],
            'labels' => $labels, // Country names
        ];
    }
}

// namespace App\Filament\Widgets;

// use App\Models\User;
// use Filament\Widgets\StatsOverviewWidget\Stat;
// use Filament\Widgets\StatsOverviewWidget as BaseWidget;

// class UserCountryStats extends BaseWidget
// {
//     protected function getStats(): array
//     {
//         $userByCountry = User::selectRaw('country, COUNT(*) as count')
//             ->groupBy('country')
//             ->pluck('count', 'country')
//             ->toArray();

//         $stats = [];
//         foreach ($userByCountry as $country => $count) {
//             $stats[] = Stat::make($country, $count);
//         }

//         return $stats;
//     }
// }

// protected function getStats(): array
    
// {
//     $countryStats = DB::table('users')
//         ->select('countries.name as country', DB::raw('COUNT(*) as count'))
//         ->join('countries', 'users.country_id', '=', 'countries.id')
//         ->whereNull('users.deleted_at')
//         ->groupBy('countries.name')
//         ->get();

//     return [
//         'countryStats' => $countryStats,
//     ];