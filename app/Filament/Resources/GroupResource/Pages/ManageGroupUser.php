<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Tables;
use App\Filament\Resources\GroupResource;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageGroupUser extends ManageRelatedRecords
{
    protected static string $resource = GroupResource::class;

    // Define the relationship to the users of the group
    protected static string $relationship = 'users';

    protected static ?string $navigationIcon = 'icon-student';

    public function getTitle(): string|Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "Manage Users for {$recordTitle}";
    }

    public function getBreadcrumb(): string
    {
        return 'Users';
    }

    public static function getNavigationLabel(): string
    {
        return 'Users';
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->recordTitleAttribute('name') // Assuming the `name` field represents the user's name
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Joined At')
                //     ->dateTime()
                //     ->sortable(),
            ])
            ->filters([])
            ->actions([
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('remove')
                ->label('Remove')
                ->action(function ($record, $livewire) {
                    // Detach the user from the group
                    $group = $livewire->getRecord(); // Get the current group
                    $group->users()->detach($record->id); // Detach the user
                })
                ->requiresConfirmation()
                ->modalHeading('Remove User')
                ->modalSubheading('Are you sure you want to remove this user from the group?'), // Allow removing users from the group
            ])
            ->headerActions([]);
    }
}
