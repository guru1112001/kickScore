<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Livewire\Attributes\Computed;

class MyCustomPersonalInfo extends MyProfileComponent
{
    protected string $view = "filament-breezy::livewire.personal-info";

    public static $sort = 10;

    public ?array $data = [];

    

    public array $only = [
        'name', 'email', 'contact_number', 'gender', 'birthday', 'city'
    ];

    public function mount(): void
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->form->fill($this->user->only($this->only));
    }

    public function getProfileFormSchema(): array
    {
        //return $this->getProfileFormSchema();
        return [$this->groupFields];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([

                        Tabs\Tab::make('Basic Details')
                            ->schema([

                                // Forms\Components\Placeholder::make('registration_number')
                                //     ->hidden(fn (Forms\Get $get): bool => !auth()->user()->is_student),
                                // /*Forms\Components\TextInput::make('registration_number')
                                //     ->disabled(),*/
                                // Forms\Components\Placeholder::make('domain.name')
                                //     ->content(fn (Forms\Get $get) => Domain::find($get('domain_id'))?->value('name'))
                                //     ->label('Domain')
                                // ->columnSpan((int) auth()->user()->is_student ? 1 : 2),
                                //Group::make()->schema([
                                    Select::make('country_code')
                                        ->options(config('country-codes'))
                                        ->label('Country Code')
                                        ->disabled()
                                        ->extraAttributes(['style' => 'width: 150px;']), // Apply custom width,
                                    Forms\Components\TextInput::make('contact_number')
                                        ->label('Contact Number'),
                                            // ->disabled(),
                                //])->columns(2),
                                Forms\Components\Select::make('gender')
                                    ->options(['Male' => 'Male', 'Female' => 'Female']),
                                Forms\Components\DatePicker::make('birthday')
                                    //->maxDate(now()->subYear(15))
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->firstDayOfWeek(7),
                                // TableRepeater::make('qualification')
                                //     ->addActionLabel('Add New Qualification')
                                //     ->headers([
                                //         Header::make('qualification')->label('Qualification'),
                                //         Header::make('year')->label('year'),
                                //         Header::make('institute_name')->label('College / School Name'),
                                //         Header::make('percentage')->label('Percentage (%)'),
                                //         Header::make('Action')->label('Action'),
                                //     ])
                                //     ->schema([
                                //         Forms\Components\Select::make('qualification_id')
                                //             ->options(Qualification::get()->pluck('name', 'id'))
                                //             ->required()
                                //             ->searchable()
                                //             ->disablePlaceholderSelection()
                                //             ->preload(),
                                //         Forms\Components\TextInput::make('year')
                                //             ->required()
                                //             ->numeric()
                                //             ->maxLength(4),
                                //         Forms\Components\TextInput::make('institute_name')
                                //             ->required(),
                                //         Forms\Components\TextInput::make('percentage')
                                //             ->required()
                                //             ->numeric()
                                //             ->maxLength(3)
                                //             ->rules('max:100')
                                //     ])
                                //     ->deleteAction(fn (Forms\Components\Actions\Action $action) => $action->requiresConfirmation())

                                //     ->columnSpan(2),
                                //                                Forms\Components\Select::make('qualification_id')
                                //                                    ->label('Qualification')
                                //                                    ->options(Qualification::pluck('name', 'id'))
                                //                                    ->searchable()
                                //                                    ->preload(),
                                //
                                //                                Forms\Components\TextInput::make('year_of_passed_out')
                                //                                    ->numeric()
                                //                                    ->maxLength(4),

                            ]),
                        Tabs\Tab::make('Additional Details')
                            ->schema([


                                Forms\Components\Textarea::make('address')
                                    ->columnSpanFull(),


                                Forms\Components\TextInput::make('city')
                                    ->label('City'),

                                // Forms\Components\Select::make('state_id')
                                //     ->label('State')
                                //     ->options(State::pluck('name', 'id'))
                                //     ->searchable()
                                //     ->preload(),


                                Forms\Components\TextInput::make('pincode')
                                    ->numeric()
                                    ->maxLength(6),
                            ]),
                        // Tabs\Tab::make('Docs')
                        //     ->schema([
                        //         Forms\Components\TextInput::make('aadhaar_number')
                        //             ->required()
                        //             ->numeric()
                        //             ->minLength(12)
                        //             ->maxLength(12),
                        //         Forms\Components\TextInput::make('linkedin_profile')
                        //             ->url()
                        //             ->maxLength(255),
                        //         Forms\Components\FileUpload::make('upload_resume')
                        //             ->required()
                        //             ->inlineLabel(true)
                        //             ->downloadable()
                        //             ->label('Resume'),
                        //         Forms\Components\FileUpload::make('upload_aadhar')
                        //             ->required()
                        //             ->label('Aadhar')
                        //             ->downloadable()
                        //             ->inlineLabel(true),


                        //     ]),
                        // Tabs\Tab::make('Parent Details')
                        //     ->schema([

                        //         Forms\Components\TextInput::make('parent_name')
                        //             ->maxLength(255),

                        //         Forms\Components\TextInput::make('parent_email')
                        //             ->email()
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('parent_aadhar')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('parent_occupation')
                        //             ->maxLength(255),
                        //         Forms\Components\Textarea::make('residential_address')
                        //             ->columnSpanFull(),
                        //     ])
                        //     ->hidden(fn () => auth()->user()->is_admin),

                        // Tabs\Tab::make('Notification')
                        //     ->schema([

                        //         //                    Forms\Components\TextInput::make('name')
                        //         //                        ->required()->columnSpan(2),
                        //         //                    Forms\Components\TextInput::make('email')
                        //         //                        ->required()->columnSpan(2),
                        //         Forms\Components\Toggle::make('receive_email_notification')
                        //             ->label('Receive Email notification.')
                        //             ->required()
                        //             ->columnSpan(2),
                        //         Forms\Components\Toggle::make('receive_sms_notification')
                        //             ->label('Receive SMS notification.')
                        //             ->required()
                        //             ->columnSpan(2)

                        //     ]),
                    ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {

        //dd( request);
        $data = collect($this->form->getState())->all();
        //dd($data);
        /*$user = User::find($this->user->id);
        $user->fill($data);
        $user->save();*/
        //$this->user->refresh();
        auth()->user()->update($data);
        $this->sendNotification();
    }

    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title('Saved Data!')
            ->send();
    }
}
