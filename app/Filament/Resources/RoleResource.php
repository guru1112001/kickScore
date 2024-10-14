<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Resources\RoleResource as baseResource;
use App\Filament\Resources\RoleResource\RelationManagers;

class RoleResource extends baseResource
// RoleResource 
{
    // protected static ?string $model = Role::class;
    protected static ?string $navigationGroup = 'Settings';

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
}
