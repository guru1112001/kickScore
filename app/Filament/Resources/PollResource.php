<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Filament\Resources\PollResource\RelationManagers;
use App\Models\Poll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PollResource extends Resource
{
    protected static ?string $model = Poll::class;

    protected static ?string $navigationIcon = 'icon-poll';
    protected static ?string $navigationGroup = 'Trivia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                Forms\Components\TextInput::make('title')->required()->placeholder('Enter the Title'),
                Forms\Components\Textarea::make('description')->placeholder('Enter the Description'),
                Forms\Components\Repeater::make('options')
                    ->relationship('options')
                    ->schema([
                        Forms\Components\TextInput::make('option')->required()->placeholder('Enter the Option'),
                    ])
                    ->createItemButtonLabel('Add Option')
                    ->minItems(2),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('options.option')
                    ->label('Options')
                    ->getStateUsing(function ($record) {
                        return implode(', ', $record->options->pluck('option')->toArray());
                    }),
                    Tables\Columns\TextColumn::make('options.votes_count')
    ->label('Vote Count')
    ->html()
    ->listWithLineBreaks(false) // Disable automatic line breaks
    ->bulleted(false) // Disable bullets if not needed
    ->getStateUsing(function ($record) {
        return $record->options->map(function ($option) {
            return "{$option->option}: {$option->votes()->count()} votes";
        })->implode('<br>'); // Add HTML <br> tag for line breaks
    }),

                    // Tables\Columns\TextColumn::make('options.votes_count')
                    // ->label('Vote Count')
                    // ->html()
                    // ->getStateUsing(function ($record) {
                    //     $totalVotes = $record->options->sum(function ($option) {
                    //         return $option->votes()->count();
                    //     });
                
                    //     return $record->options->map(function ($option) use ($totalVotes) {
                    //         $voteCount = $option->votes()->count();
                    //         $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100) : 0;
                
                    //         // Create progress bar using HTML
                    //         return "
                    //             <div>
                    //                 <strong>{$option->option}</strong>: {$voteCount} votes ({$percentage}%)
                    //                 <div style='background-color: #e0e0e0; border-radius: 10px; width: 100%; height: 15px;'>
                    //                     <div style='width: {$percentage}%; background-color: #4caf50; height: 100%; border-radius: 10px;'></div>
                    //                 </div>
                    //             </div>
                    //         ";
                    //     })->implode('<br>');
                    // }),
                
                
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolls::route('/'),
            'create' => Pages\CreatePoll::route('/create'),
            'edit' => Pages\EditPoll::route('/{record}/edit'),
        ];
    }
}
