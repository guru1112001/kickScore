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
                                        // ->disabled()
                                        ->extraAttributes(['style' => 'width: 150px;']), // Apply custom width,
                                    Forms\Components\TextInput::make('contact_number')
                                        ->label('Contact Number'),
                                            // ->disabled(),
                                //])->columns(2),
                                Forms\Components\Select::make('gender')
                                    ->options(['Male' => 'Male', 'Female' => 'Female']),
                                
                               

                            ]),
                        Tabs\Tab::make('Additional Details')
                            ->schema([


                                // Forms\Components\Textarea::make('address')
                                //     ->columnSpanFull(),
                                Forms\Components\DatePicker::make('birthday')
                                    //->maxDate(now()->subYear(15))
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->firstDayOfWeek(7),

                                Forms\Components\TextInput::make('Country')
                                    ->label('Country'),

                                // Forms\Components\Select::make('state_id')
                                //     ->label('State')
                                //     ->options(State::pluck('name', 'id'))
                                //     ->searchable()
                                //     ->preload(),


                                
                            ]),
                        
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
