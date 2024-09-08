<?php

// namespace App\Filament\Widgets;

// use App\Models\Leaderboard;
// use App\Models\User;
// use Filament\Tables;
// use App\Models\Batch;
// use Filament\Tables\Table;
// use Filament\Widgets\Concerns\InteractsWithPageFilters;
// use Filament\Widgets\TableWidget as BaseWidget;
// use Illuminate\Database\Eloquent\Builder;

// // Add this import
// class BatchStudentsTable extends BaseWidget
// {
//     use InteractsWithPageFilters;

//     //protected int|string|array $columnSpan = 'full';

//     protected static ?int $sort = 4;

//     protected static ?string $heading = 'Batch Students';

//     public function table(Table $table): Table
//     {
//         return $table
//             ->query(
//                 Leaderboard::query()
//                     ->when($this->filters && $this->filters['startDate'], function ($q) {
//                         $q->where('enroll_date','>=',$this->filters['startDate']);
//                         $q->where('enroll_date','<=',$this->filters['endDate']);
//                     })
//                     ->when($this->filters && $this->filters['course'], function ($q) {
//                         $q->where('course_id','>=',$this->filters['course']);
//                     })
//                     ->when($this->filters && $this->filters['batch'], function ($q) {
//                         $q->where('batch_id','>=',$this->filters['batch']);
//                     })
//             )->emptyStateDescription('No Records')
//             ->emptyStateHeading('')
//             ->columns([
//                 Tables\Columns\TextColumn::make('user_name')
//                     ->label('Name'),
//                 //->sortable()
//                 //->searchable(),

//                 Tables\Columns\TextColumn::make('contact')
//                     ->label('Contact'),
//                 //->sortable()
//                 //->searchable(),

//                 Tables\Columns\TextColumn::make('total_attendances')
//                     ->label('Attendance'),
//                 Tables\Columns\TextColumn::make('total_assignments')
//                     ->label('Submitted Assignments'),


//             ])
//             ->filters([

// //                Tables\Filters\SelectFilter::make('batch')
// //                    ->label('Filter by Batch')
// //                    ->options(Batch::pluck('name', 'id')->toArray())
// //                    ->query(function (Builder $query, array $data) {
// //
// //                        return $query->when(
// //
// //                            $data['value'],
// //
// //                            fn(Builder $query, $batchId) => $query->whereHas('batchesstudents', fn(Builder $q) => $q->where('batch_id', $batchId))
// //
// //                        );
// //
// //                    }),

//                 // Tables\Filters\SelectFilter::make('course')

//                 // ->label('Filter by Course')

//                 // ->options(Course::pluck('name', 'id')->toArray())

//                 // ->query(function (Builder $query, array $data) {

//                 //     return $query->when(

//                 //         $data['value'],

//                 //         fn (Builder $query, $courseId) => $query->whereHas('batchesstudents', function (Builder $q) use ($courseId) {

//                 //             $q->whereHas('batch', function (Builder $batchQuery) use ($courseId) {

//                 //                 $batchQuery->where('course_package_id', 'LIKE', '%_' . $courseId);

//                 //             });

//                 //         })

//                 //     );

//                 // }),

//                 // Tables\Filters\SelectFilter::make('course')

//                 //     ->label('Filter by Course')

//                 //     ->options(Course::pluck('name', 'id')->toArray())

//                 //     ->query(function (Builder $query, array $data) {

//                 //         return $query->when(

//                 //             $data['value'],

//                 //             fn (Builder $query, $courseId) => $query->whereHas('batchesstudents.course', fn (Builder $q) => $q->where('id', $courseId))

//                 //         );

//                 //     }),

//             ]);
//     }

//     public static function canView(): bool
//     {
//         return auth()->user()->role_id == 1 || auth()->user()->role_id == 7;
//     }

// }
