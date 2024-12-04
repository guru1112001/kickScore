<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeagueResource\Pages;
use App\Filament\Resources\LeagueResource\RelationManagers;
use App\Models\League;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeagueResource extends Resource
{
    protected static ?string $model = League::class;
    
    protected static ?string $navigationGroup = 'Leagues';

    protected static ?string $navigationIcon = 'icon-leagues';
    public static function canCreate(): bool
   {
      return false;
   }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                // Tables\Columns\TextColumn::make('sport_id'),
                // Tables\Columns\TextColumn::make('country_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ImageColumn::make('image_path')->label('Image')->width(79)->height(69),
                Tables\Columns\ToggleColumn::make('active'),
                // Tables\Columns\TextColumn::make('short_code'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('sub_type'),
                Tables\Columns\TextColumn::make('last_played_at')->dateTime(),
                // Tables\Columns\TextColumn::make('category'),
                // Tables\Columns\TextColumn::make('created_at')->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLeagues::route('/'),
            'create' => Pages\CreateLeague::route('/create'),
            // 'edit' => Pages\EditLeague::route('/{record}/edit'),
        ];
    }
}
