<?php

return [

    'resources' => [
        //'AutenticationLogResource' => \Tapp\FilamentAuthenticationLog\Resources\AuthenticationLogResource::class,
        'AutenticationLogResource' => App\Filament\Resources\AuthenticationLogResource::class,
    ],

    'authenticable-resources' => [
        \App\Models\User::class,
    ],

    'navigation' => [
        'authentication-log' => [
            'sort' => 1,
            'icon' => 'heroicon-o-shield-check',
        ],
    ],

    'sort' => [
        'column' => 'login_at',
        'direction' => 'desc',
    ],

];
