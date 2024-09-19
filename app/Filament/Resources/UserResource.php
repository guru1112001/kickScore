<?php

namespace App\Filament\Resources;

use App\Models\Batch;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Qualification;
use App\Models\User;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Enums\FiltersLayout;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    //protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationIcon = 'icon-student';

    protected static ?string $navigationGroup = 'User';

    protected static ?int $navigationSort = -2;

    protected static bool $isScopedToTenant = false;
    protected static ?array $countryCodes = null;


//    public static function infolist(Infolist $infolist): Infolist
//    {
//        return $infolist
//        ->schema([
//            Infolists\Components\TextEntry::make('name'),
//        ]);
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label('Avatar')
                            ->downloadable()
                            ->columns(2)
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('role_id')
                            ->relationship('role', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->hiddenOn('edit'),
                        // Forms\Components\TextInput::make('registration_number')
                        //     ->hidden(fn(Forms\Get $get): bool => $get('role_id') != 6)
                        //     ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->default("")
                            ->autocomplete('off')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        Group::make()->schema([
                            Select::make('country_code')
                                ->options(config('country-codes'))
                                ->label('Country Code')
                                ->required()
                                ->searchable()
                                ->extraAttributes(['style' => 'width: 150px;']), // Apply custom width,
                            Forms\Components\TextInput::make('phone')
                                ->label('Contact Number')
                                ->required()
                                ->numeric()
                                ->unique()
                                ->maxLength(10),
                        ])->columns(2),
                        Forms\Components\Select::make('gender')
                            ->options(['Male' => 'Male', 'Female' => 'Female']),
                        Forms\Components\DatePicker::make('birthday')
                            //->maxDate(now()->subYear(15))
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->firstDayOfWeek(7)
                            ->hiddenOn('create'),
                        /*Forms\Components\DateTimePicker::make('email_verified_at'),*/
                        Forms\Components\TextInput::make('password')
                            //->label(fn(string $context) => $context === 'create' ? 'Password' : 'Change Password')
                            ->hiddenOn('edit')
                            ->password()
                            // ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            // ->dehydrated(fn ($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),

                    ])->columns(2),


    //              

            ])->extraAttributes(['autocomplete' => 'off']);
    }

    // public static function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    // {
    //     return User::query()->whereHas('teams', function ($query) {
    //         $query->where('id', Filament::getTenant());
    //     })->where('role_id', 6);
    // }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')->label('Avatar')
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('role.name')
                //     ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
//            ->filters([
//
//            ])
            // ->filters([
            //     Tables\Filters\TrashedFilter::make(),
            //     SelectFilter::make('batch')
            //         ->label('Batch')
            //         ->relationship('batches', 'name')
            //         ->searchable()
            //         ->preload(),
            // ], FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label('')
                //                    ->mutateFormDataUsing(function (array $data) {
                //                        if(!empty($data['password'])) {
                //                            $data['password'] = Hash::make($data['password']);
                //                        } else {
                //                          unset($data['password']);
                //                        }
                //                        return $data;
                //                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),

                // Tables\Actions\BulkAction::make('assignToBatch')
                //     ->label('Assign to Batch')
                //     ->action(function (Collection $records, array $data) {
                //         foreach ($records as $record) {
                //             // Remove user from older batches
                //             $record->batches()->detach();
                //             // Assign user to the new batch
                //             $record->batches()->attach($data['batch_id']);
                //         }
                //         // Show a success notification
                //         Notification::make()
                //             ->title('Success')
                //             ->body('Users have been successfully assigned to the batch.')
                //             ->success()
                //             ->send();
                //     })
            //         ->form([
            //             // Define the form to select the new batch
            //             Forms\Components\Select::make('batch_id')
            //                 ->label('Select Batch')
            //                 ->options(\App\Models\Batch::whereHas('team')->pluck('name', 'id'))
            //                 ->searchable()
            //                 ->required(),
            //         ]),
            ]);
    }

//    public static function getRelations(): array
//    {
//        return [
//            //
//        ];
//    }

    public static function getPages(): array
    {
        $pages = [
            'index' => Pages\ListUsers::route('/'),
            // 'batches' => Pages\ManageBatches::route('/{record}/batches'),
            // 'assignments' => Pages\Assignments::route('/{record}/assignments'),
            // 'branches' => Pages\ManageBranches::route('/{record}/branches'),
            // 'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'changepassword' => Pages\ChangePassword::route('/{record}/changepassword'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];

        return $pages;
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        $pages = [
            //Pages\ListUsers::class,
            Pages\ViewUser::class,
            Pages\EditUser::class,
            Pages\ChangePassword::class,
            // Pages\ManageBatches::class,
            // Pages\ManageBranches::class,
            // Pages\Assignments::class,
        ];

        // if ($page->getRecord()->role_id == 6) {
        //     unset($pages[4]);
        // }
        return $page->generateNavigationItems($pages);
    }

    // public static function relations(): array
    // {
    //     return [
    //         Assignments::class,
    //     ];
    // }
}
