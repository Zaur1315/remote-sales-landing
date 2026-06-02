<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Remote Sales Admin')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Zinc,
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->darkMode(true)
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                static fn(): string => Blade::render(<<<'HTML'
                    <style>
                        :root {
                            --admin-brand-radius: 18px;
                        }

                        .fi-sidebar {
                            background:
                                linear-gradient(180deg, rgba(24, 24, 27, 0.98), rgba(39, 39, 42, 0.98)) !important;
                        }

                        .fi-sidebar-header {
                            border-bottom: 1px solid rgba(245, 158, 11, 0.25);
                        }

                        .fi-sidebar-item-active a,
                        .fi-sidebar-item a:hover {
                            background: rgba(245, 158, 11, 0.16) !important;
                        }

                        .fi-topbar {
                            backdrop-filter: blur(14px);
                        }

                        .fi-ta-ctn,
                        .fi-section,
                        .fi-fo-tabs {
                            border-radius: var(--admin-brand-radius) !important;
                        }
                    </style>
                HTML
                )
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //
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
                Authenticate::class,
            ]);
    }
}
