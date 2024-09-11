<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Checkbox;
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
        try {
            $credentials = $this->getCredentialsFromFormData($this->form->getState());
            $loginField = array_keys($credentials)[0]; // This will be either 'email' or 'contact_number'
            $loginValue = $credentials[$loginField];

            $user = User::where($loginField, $loginValue)->first();

            if ($user && !Hash::check($credentials['password'], $user->password)) {
                // If the password is correct but not hashed with Bcrypt, rehash it
                $user->password = Hash::make($credentials['password']);
                $user->save();
            }

            return parent::authenticate();
        } catch (ValidationException $e) {
            throw $e;
        }
    }
}