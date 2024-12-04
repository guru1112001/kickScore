<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \App\Events\GroupCreated::class => [
            \App\Listeners\NotifyUsersInSameCountry::class,
        ],
        Registered::class => [
            // SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UpdateSessionId',
        ],
        SocialiteWasCalled::class => [
            // Add your Socialite providers here
            \SocialiteProviders\Instagram\InstagramExtendSocialite::class.'@handle',
            \SocialiteProviders\Apple\AppleExtendSocialite::class.'@handle',
            \SocialiteProviders\Microsoft\MicrosoftExtendSocialite::class.'@handle',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
