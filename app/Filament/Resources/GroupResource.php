<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Group;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\GroupResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Filament\Resources\GroupResource\RelationManagers\UsersRelationManager;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;

class GroupResource extends Resource
{
protected static ?string $model = Group::class;
protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

protected static ?string $navigationGroup = 'Fan MeetUps';
public static ?string $label = 'Fan MeetUps';

protected static ?string $navigationIcon = 'icon-room';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make()
            ->schema([
                Forms\Components\Hidden::make('created_by')
                ->default(fn()=>Auth::id()),
            TextInput::make('name')->required()
            ->placeholder("Enter the name"),
            // Toggle::make('is_scheduled')->label('Scheduled')->inline(false),
            DateTimePicker::make('schedule_start')
                ->label('Start Time')
                ->placeholder("Enter the Date and Time")
                // ->visible(fn ($get) => $get('is_scheduled'))
                ->nullable(),
            Forms\Components\Hidden::make('is_active')
            ->default(true)
            // DateTimePicker::make('schedule_end')
            //     ->label('End Time')
            //     // ->visible(fn ($get) => $get('is_scheduled'))
            //     ->nullable(),
                ])
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // TextColumn::make('id')->sortable(),
            TextColumn::make('name')->sortable()->searchable(),
            ToggleColumn::make('is_active')->label('Active'),
            TextColumn::make('creator.name'),
            TextColumn::make('schedule_start')->label('Start Time')->dateTime(),
            TextColumn::make('users_count')
            ->label('Users Count')
            ->counts('users') // This uses the `users` relationship to count related users
            ->sortable(),
            
            // TextColumn::make('schedule_end')->label('End Time')->dateTime(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()

        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

// public static function getRelations(): array
// {
//     return [
//         UsersRelationManager::class,
//     ];
// }


public static function getPages(): array
        {
            return [
                'index' => Pages\ListGroups::route('/'),
                'create' => Pages\CreateGroup::route('/create'),
                'edit' => Pages\EditGroup::route('/{record}/edit'),
                // 'view' => Pages\ViewGroup::route('/{record}'),
                'messages' => Pages\ManageGroupMessage::route('/{record}/messages'),
                'users' => Pages\ManageGroupUser::route('/{record}/users'),
                // 'likes' => Pages\ManageLike::route('/{record}/likes'),
            ];
        }
        public static function getRecordSubNavigation(Page $page): array
        {
            return $page->generateNavigationItems([
                Pages\ListGroups::class,
                // Pages\EditPost::class,
                Pages\ManageGroupMessage::class,
                Pages\ManageGroupUser::class,
                // Pages\ManageLike::class,
    
            ]);
        }
}
