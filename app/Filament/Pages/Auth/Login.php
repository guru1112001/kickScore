<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('login_type')
                    ->options([
                        'email' => 'Email',
                        'contact_number' => 'Contact Number',
                    ])
                    ->default('email')
                    ->reactive(),
                $this->getLoginTypeComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->extraAttributes(['class' => 'custom-login-form'])
            ->statePath('data');
    }

    protected function getLoginTypeComponent(): TextInput
    {
        return TextInput::make('login')
            ->label(function ($get) {
                return $get('login_type') === 'email' ? 'Email address' : 'Contact Number';
            })
            ->email(fn ($get) => $get('login_type') === 'email')
            ->tel(fn ($get) => $get('login_type') === 'contact_number')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $loginType = $data['login_type'] ?? 'email';
        $loginField = $loginType === 'email' ? 'email' : 'contact_number';

        return [
            $loginField => $data['login'],
            'password' => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
{
    $credentials = $this->getCredentialsFromFormData($this->form->getState());
    $loginField = array_keys($credentials)[0]; // Email or contact number

    $user = User::where($loginField, $credentials[$loginField])
                ->first();

    // Custom validation for login
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        // Incorrect credentials notification
        \Filament\Notifications\Notification::make()
            ->title('Login failed')
            ->body('The provided credentials are incorrect.')
            ->icon('heroicon-o-x-circle')
            ->iconColor('danger')
            ->send();

        throw ValidationException::withMessages([
            'login' => 'The provided credentials are incorrect.',
        ]);
    }

    // Check if the user has the 'fan' role
    if ($user->role === 'fan') {
        // Role-based notification for fan users
        \Filament\Notifications\Notification::make()
            ->title('Fan Role Access')
            ->body('Your account has limited access because you are a fan.')
            ->icon('heroicon-o-information-circle')
            ->iconColor('warning')
            ->send();

        // You can add more logic here if necessary, e.g., restrict access
    }

    return parent::authenticate();
}

}
