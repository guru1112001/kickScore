<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use App\Models\Team;
use App\Models\User;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Auth\Login;
use Filament\Support\Colors\Color;
use App\Livewire\CustomPersonalInfo;
use Filament\Support\Enums\MaxWidth;
use App\Livewire\MyCustomPersonalInfo;
use App\Filament\Resources\RoleResource;
use App\Http\Middleware\ApplyTenantScopes;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use DutchCodingCompany\FilamentSocialite\Provider;
//use App\Filament\Pages\Auth\EditProfile;
// use App\Filament\Pages\Auth\Tenancy\EditTeamProfile;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
// use App\Filament\Pages\Tenancy\RegisterTeam;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
//use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;

class AdministratorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->viteTheme('resources/css/filament/administrator/theme.css')
            ->id('administrator')
            ->path('administrator')
            ->login(Login::class)
            ->registration()
            ->passwordReset()
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->font('Poppins')
            //->profile(EditTeamProfile::class)
            //->profile(isSimple: false)
            ->plugins([
                FilamentSocialitePlugin::make()
                ->providers([
                    Provider::make('google')
                        ->label('Google')
                        // ->scopes(['...'])
                        ->icon('icon-google'),
                        // ->stateless(false),
                        // ->color(Color::primary())
                        // ->scopes(['profile', 'email']),
                        
                    Provider::make('facebook')
                        ->label('Facebook')
                        ->icon('icon-facebook'),
                        // ->color(Color::primary()),

                    Provider::make('instagram')
                        ->label('Instagram')
                        ->icon('icon-instagram'),
                        // ->color(Color::primary()),

                    Provider::make('apple')
                        ->label('Apple')
                        ->icon('icon-apple'),
                    Provider::make('microsoft')
                        ->label('Microsoft')
                        ->icon('icon-microsoft'),
                        // ->color(Color::primary())
                ])
                ->slug('administrator')
                ->registration(true)
                // ->domainAllowList(['localhost'])  // Enables new user registration
                ->userModelClass(User::class) // Specifies the User model
                ->createUserUsing(function (string $provider, SocialiteUserContract $oauthUser, FilamentSocialitePlugin $plugin) {
                    // Logic to create or update a user in your database
                    $user = User::updateOrCreate(
                        ['email' => $oauthUser->getEmail()],
                        [
                            'name' => $oauthUser->getName(),
                            'avatar_url' => $oauthUser->getAvatar(),
                            'role_id'=>'1',
                            'password' => null,
                        ]
                    );
    
                    return $user;
                })
                ->resolveUserUsing(function (string $provider, SocialiteUserContract $oauthUser, FilamentSocialitePlugin $plugin) {
                    // Logic to retrieve an existing user by email
                    return User::where('email', $oauthUser->getEmail())->first();
                }),
                
                // FilamentSocialitePlugin::make()
                // ->providers([
                //     Provider::make('google')
                //         ->label('Google')
                //         // ->icon('google')
                //         // ->color(Colors::blue())
                //         ->scopes(['email', 'profile']),

                //     Provider::make('facebook')
                //         ->label('Facebook')
                //         // ->icon('fa-brands fa-facebook')
                //         // ->color(Colors::blue())
                //         ->scopes(['email', 'public_profile']),

                //     Provider::make('instagram')
                //         ->label('Instagram')
                //         // ->icon('fa-brands fa-instagram')
                //         // ->color(Colors::pink())
                //         ->scopes(['user_profile', 'user_media']),

                //     Provider::make('apple')
                //         ->label('Apple')
                //         // ->icon('fa-brands fa-apple')
                //         // ->color(Colors::black())
                //         ->stateless(true),
                // ])
                // ->slug('admin')  // Optional: define panel slug
                // ->registration(true), // Enable new user registration
                
                
                FilamentFullCalendarPlugin::make(),
                TableLayoutTogglePlugin::make()
                    ->setDefaultLayout('grid')
                    ->persistLayoutInLocalStorage(true) // allow user to keep his layout preference in his local storage
                    ->shareLayoutBetweenPages(false) // allow all tables to share the layout option (requires persistLayoutInLocalStorage to be true)
                    ->displayToggleAction() // used to display the toogle button automatically, on the desired filament hook (defaults to table bar)
                    ->listLayoutButtonIcon('heroicon-o-list-bullet')
                    ->gridLayoutButtonIcon('heroicon-o-squares-2x2'),
				\BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(RoleResource::class),
                BreezyCore::make()
                ->myProfile(
                    shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                    shouldRegisterNavigation: true, // Adds a main navigation item for the My Profile page (default = false)
                    navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                    hasAvatars: true, // Enables the avatar upload form component (default = false)
                    slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                )
                    ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
                    ->myProfileComponents([CustomPersonalInfo::class])

                    ->myProfileComponents([
                    // 'personal_info' => CustomPersonalInfo::class,
                   'personal_info' => MyCustomPersonalInfo::class, // replaces UpdatePassword component with your own.
                    // 'two_factor_authentication' => ,
                    // 'sanctum_tokens' =>
                ])
                ->enableTwoFactorAuthentication(
                    force: false, // force the user to enable 2FA before they can use the application (default = false)
                    //action: CustomTwoFactorPage::class // optionally, use a custom 2FA page
                )
			])
            ->colors([
                'primary' => Color::Orange,
                'secondary' => Color::Blue,
            ])
            ->brandLogo(asset('images/KickScore.png'))
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->tenant(Team::class)
            /*->tenantMiddleware([
                ApplyTenantScopes::class,
            ], isPersistent: true)*/
            //->tenantRegistration(RegisterTeam::class)
            //->tenantProfile(EditTeamProfile::class)
            // ->tenantMenuItems([
            //     'profile' => MenuItem::make()->label('Edit team profile'),
            //     // ...
            // ])
            ;
    }
}
