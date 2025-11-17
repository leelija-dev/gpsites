<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
// use App\Filament\Pages\UpdateProfile;


class AdminPanelProvider extends PanelProvider
{
    // public function panel(Panel $panel): Panel
    // {
    //     return $panel
    //         ->default()
    //         ->id('admin')
    //         ->path('admin')
    //         ->authGuard('admin')
    //         ->login()
    //         ->colors([
    //             'primary' => Color::Amber,
    //         ])
    //         ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
    //         ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
    //         ->pages([
    //             Dashboard::class,
    //         ])
    //         ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
    //         ->widgets([
    //             AccountWidget::class,
    //             FilamentInfoWidget::class,
    //         ])
    //         ->userMenuItems([
    //             // custom navbar profile menu
    //             'profile' => fn (Action $action) => $action
    //                 ->label(fn () => auth('admin')->user()?->name ?? 'Profile') // show admin name
    //                 ->icon('heroicon-o-user'),
    //                 //->url(fn () => route('filament.admin.pages.update-profile')),

    //             //my account link
    //             Action::make('my-account')
    //                 ->label('My Account')
    //                 ->icon('heroicon-o-user-circle')
    //                 ->url(fn () => route('filament.admin.pages.update-profile')),

    //             // You can add other actions (these will be shown in the menu where Actions are listed).
    //             // Filament typically renders the Theme switcher automatically in the menu UI,
    //             // so you usually don't need to add it manually.

    //             // logout link
    //             'logout' => fn (Action $action) => $action->label('Logout'),
    //         ])

    //         ->middleware([
    //             EncryptCookies::class,
    //             AddQueuedCookiesToResponse::class,
    //             StartSession::class,
    //             AuthenticateSession::class,
    //             ShareErrorsFromSession::class,
    //             VerifyCsrfToken::class,
    //             SubstituteBindings::class,
    //             DisableBladeIconComponents::class,
    //             DispatchServingFilamentEvent::class,
    //         ])
    //         ->authMiddleware([
    //             Authenticate::class . ':admin',
    //         ]);
    // }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('admin')
            ->login()
            ->passwordReset()

            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                // custom navbar profile menu
                'profile' => fn(Action $action) => $action
                    ->label(fn() => auth('admin')->user()?->name ?? 'Profile') // show admin name
                    ->icon('heroicon-o-user'),
                //->url(fn () => route('filament.admin.pages.update-profile')),

                //my account link
                Action::make('my-account')
                    ->label('My Account')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn() => route('filament.admin.pages.update-profile')),

                // You can add other actions (these will be shown in the menu where Actions are listed).
                // Filament typically renders the Theme switcher automatically in the menu UI,
                // so you usually don't need to add it manually.

                // logout link
                'logout' => fn(Action $action) => $action->label('Logout'),
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
            ->authMiddleware([
                Authenticate::class . ':admin',
            ]);
    }
}
