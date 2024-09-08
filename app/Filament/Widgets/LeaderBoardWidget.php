<?php

// namespace App\Filament\Widgets;

// use App\Models\Leaderboard;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\Concerns\InteractsWithPageFilters;
// use Filament\Widgets\TableWidget as BaseWidget;
// use Illuminate\Support\Facades\Request;

// class LeaderBoardWidget extends BaseWidget
// {

//     use InteractsWithPageFilters;

//     protected static ?int $sort = 2;

//     protected static ?string $heading = 'Leaderboard';

//     public function table(Table $table): Table
//     {
//         return $table
//             ->query(
//                 Leaderboard::query()
//                     ->when($this->filters && $this->filters['startDate'], function ($q) {
//                         $q->whereDate('enroll_date', '>=', $this->filters['startDate']);
//                         $q->whereDate('enroll_date', '<=', $this->filters['endDate']);
//                     })
//                     ->when($this->filters && $this->filters['course'], function ($q) {
//                         $q->where('course_id', '>=', $this->filters['course']);
//                     })
//                     ->when($this->filters && $this->filters['batch'], function ($q) {
//                         $q->where('batch_id', '>=', $this->filters['batch']);
//                     })
// //                    ->select([
// //                        'user_name',
// //                        'weighted_score',
// //                        // Using MySQL's ROW_NUMBER() to create a rank. Adjust based on your DB support.
// //                        //DB::raw('ROW_NUMBER() OVER (ORDER BY weighted_score DESC) as rank')
// //                    ])
//                     ->limit(5)
//             )
//             ->columns([
//                 Tables\Columns\TextColumn::make('user_name')
//                     ->label('Name')
//                     ->sortable(),
//                 Tables\Columns\TextColumn::make('user_id')
//                     ->label('#')
//                     ->formatStateUsing(function ($state, $record, $column, $livewire) {
//                         $index = $livewire->cachedTableRecords->search(function ($leaderboard, $key) use ($state) {
//                             return $leaderboard->user_id == $state; // Replace 'attribute' and 'value' with actual data
//                         });
//                         return "Rank " . $index + 1;
//                         //dd($state, $livewire->cachedTableRecords->where('user_id', $state)->first());
//                     }),
// //                Tables\Columns\TextColumn::make('formatted_weighted_score')
// //                    ->label('Score')
// //                    ->sortable(),
// //
// //                Tables\Columns\TextColumn::make('rank')
// //                    ->label('Rank')
// //                    ->sortable(),

//                 // Add any additional columns you may need here
//             ])
//             ->filters([
//                 // Define filters if necessary, example given below:
//                 Tables\Filters\Filter::make('Top 10')
//                     ->query(fn($query) => $query->orderBy('weighted_score', 'desc')
//                         ->limit(5)
//                     )->hidden()
//             ])
//             ->paginated(false)
//             ->defaultSort('weighted_score', 'desc'); // Set a default sort if desired
//     }

//     protected function getRecordsPerPage(): int
//     {
//         return 5; // Customize as needed
//     }
// }
