<?php

namespace App\Filament\Pages;

use App\Models\Batch;
use App\Models\Course;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
//     use BaseDashboard\Concerns\HasFiltersForm;

//     public function filtersForm(Form $form): Form
//    {
//     if (auth()->user()->role_id == 6)
//     {
//         // Return an empty form schema for users with role_id 6
//         return $form->schema([]);
//     }
        
//         return $form
//             ->schema([
//                 Section::make()
//                     ->schema([
//                         Select::make('course')
//                             ->label('Course')
//                             ->options(Course::all()->pluck('name', 'id'))
//                             ->searchable(),
//                         Select::make('batch')
//                             ->label('Batch')
//                             ->options(Batch::all()->pluck('name', 'id'))
//                             ->searchable(),
//                         DatePicker::make('startDate')
//                             ->native(false)
//                             ->displayFormat('d/m/Y')
//                             ->firstDayOfWeek(7)
//                             ->default(now()->subDays(7)->startOfDay()->toDateString())
//                             ->maxDate(fn(Get $get) => $get('endDate') ?: now()->toDateString()),
//                         DatePicker::make('endDate')
//                             ->native(false)
//                             ->displayFormat('d/m/Y')
//                             ->firstDayOfWeek(7)
//                             ->default(now()->startOfDay()->toDateString())
//                             ->minDate(fn(Get $get) => $get('startDate') ?: now()->toDateString())
//                             ->maxDate(now()->toDateString()),
//                     ])->heading('Filter')
//                     ->columns(4),
//             ]);
//     }
}
