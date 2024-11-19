<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Infolists\Infolist;
use App\Tables\Columns\UserColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\GroupResource;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageGroupMessage extends ManageRelatedRecords
{
    protected static string $resource = GroupResource ::class;
    

protected static string $relationship = 'messages';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public function getTitle(): string|Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "Manage {$recordTitle} Messages";
    }

    public function getBreadcrumb(): string
    {
        return 'Messages';
    }

    public static function getNavigationLabel(): string
    {
        return 'Messages';
    }

    public function form(Form $form): Form
    {


        return $form
            ->schema([

                Forms\Components\TextInput::make('content')
                    ->required()
                    ->label('Message'),
                Forms\Components\Select::make('user_id')
                    ->options(\App\Models\User::all()->pluck('name', 'id'))
                    ->default(Auth::id())
                    ->label('message by')
                    ->required(),
                // ->required(),
                Forms\Components\Select::make('group_id')
                    ->hidden('create')
                    ->default(request('group_id'))
                    // ->relationship('group', 'content'),

                // ->searchable()


            ])
            ->columns(1);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('title'),
                TextEntry::make('customer.name'),
                IconEntry::make('is_visible')
                    ->label('Visibility'),
                TextEntry::make('content')
                    ->markdown(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([

                Tables\Columns\TextColumn::make('content')
                    ->label('Message')
                    // ->searchable()
                    ,

                    Tables\Columns\TextColumn::make('user.name')
                    ->label('Messaged By'),

                Tables\Columns\TextColumn::make('created_at')
                    // ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
