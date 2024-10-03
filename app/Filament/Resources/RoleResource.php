<?php

namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Resources\RoleResource as BaseRole;

class RoleResource extends BaseRole
{
    protected static ?string $navigationGroup = 'Settings';
}

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             //
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    // public static function getRelations(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListRoles::route('/'),
    //         'create' => Pages\CreateRole::route('/create'),
    //         'edit' => Pages\EditRole::route('/{record}/edit'),
    //     ];
    // }
