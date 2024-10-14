<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FanPhotoResource\Pages;
use App\Filament\Resources\FanPhotoResource\RelationManagers;
use App\Models\FanPhoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class FanPhotoResource extends Resource
{
    protected static ?string $model = FanPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Fan Spotlight';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                ->schema([
                Forms\Components\TextInput::make('caption')->required()->columnspan(1),
                Forms\Components\FileUpload::make('image')->required(),
                Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    ])
                    ->default('draft')
                    ->required(),
                    Forms\Components\Toggle::make('acknowledge')->label('Acknowledge')->extraAttributes(['class'=>'custom-toogle'])->default(True),
                    ])->columnspan(2)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Posted By'),
                Tables\Columns\ImageColumn::make('image')->label('Photo'),
                Tables\Columns\TextColumn::make('caption')->label('Caption'),
                Tables\Columns\ToggleColumn::make('acknowledge')->label('Acknowledge'),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'draft' => 'Draft',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])->label('Status'),
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
            'index' => Pages\ListFanPhotos::route('/'),
            'create' => Pages\CreateFanPhoto::route('/create'),
            'edit' => Pages\EditFanPhoto::route('/{record}/edit'),
        ];
    }
}
