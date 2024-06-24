<?php

declare(strict_types=1);

namespace Modules\Manager\Providers\Filament\Panels;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop()
            ->id('manager')
            ->path('manager')
            ->brandName(config('app.name'))
            ->login()
            ->profile()
            ->colors(
                [
                    'primary'   => Color::hex('#9B59B6'),
                    'secondary' => Color::hex('#E67E22'),
                ]
            )
            ->font('https://fonts.google.com/share?selection.family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900')
            ->discoverModulesResources()
            ->pages(
                [
                    Pages\Dashboard::class,
                ]
            )
            ->widgets(
                [
                    Widgets\AccountWidget::class,
                ]
            )
            ->plugins([
                FilamentShieldPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['id', 'en']),
            ])
            ->middleware(
                [
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
                    DisableBladeIconComponents::class,
                    DispatchServingFilamentEvent::class,
                ]
            )
            ->persistentMiddleware(['universal'])
            ->domains(config('app.domains', ['localhost']))
            ->authMiddleware(
                [
                    Authenticate::class,
                ]
            );
    }
}
