<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Models\Setting;
use Awcodes\Curator\Models\Media;
use Awcodes\Curator\CuratorPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Z3d0X\FilamentFabricator\FilamentFabricatorPlugin;

class AdminPanelProvider extends PanelProvider
{
    private const DEFAULT_ADMIN_PANEL_LOGO = 'img/core/logo-app.svg';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->breadcrumbs(true)
            ->login()
            ->maxContentWidth('Full')
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName(fn (): string => $this->firstSettingRecord()?->application['name'] ?? config('app.name'))
            ->brandLogo(fn (): string|Htmlable => $this->resolveAdminPanelBrandLogo())
            ->brandLogoHeight(fn (): string => $this->resolveAdminPanelBrandLogoHeight())
            ->darkModeBrandLogo(fn (): ?string => $this->resolveAdminPanelDarkModeBrandLogo())
            ->favicon(asset('img/core/favicon.png'))
            ->navigationItems([
                NavigationItem::make(__('View Website'))
                    ->url(env('APP_URL'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-up-right')
                    ->sort(-1),
                NavigationItem::make(__('Background & Logo'))
                    ->icon('heroicon-o-paint-brush')
                    ->url('/admin/settings/'.$this->getSetting().'/edit-appearance')
                    ->group(__('Website Design'))
                    ->sort(1),
                NavigationItem::make(__('Navigation'))
                    ->icon('heroicon-o-bars-3-bottom-left')
                    ->url('/admin/settings/'.$this->getSetting().'/edit-navigation')
                    ->group(__('Website Design'))
                    ->sort(1),
                NavigationItem::make(__('Log Viewer'))
                    ->icon('heroicon-o-arrow-up-right')
                    ->url('/admin/logs')
                    ->group(__('Settings'))
                    ->sort(3),
            ])
            ->plugins([
                FilamentFabricatorPlugin::make(),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media Library')
                    ->navigationIcon('heroicon-o-rectangle-stack')
                    ->navigationSort(2)
                    ->navigationCountBadge(),
            ])
            ->resources([
                config('filament-logger.activity_resource'),
            ])
            ->colors([
                'primary'   => Color::Purple,
                'secondary' => Color::Zinc,
                'gray'      => Color::Zinc,
            ])
            ->navigationGroups([
                'Core Features',
                'Website Design',
                'App Sections',
                'Settings',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
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

    private function getSetting()
    {
        if (Schema::hasTable('settings')) {
            $setting = Setting::first(['id']);

            return $setting ? $setting->value('id') : null;
        }

        return null;
    }

    private function firstSettingRecord(): ?Setting
    {
        if (! Schema::hasTable('settings')) {
            return null;
        }

        return Setting::first();
    }

    private function mediaUrlFromDesignId(mixed $id): ?string
    {
        if (blank($id)) {
            return null;
        }

        $id = is_array($id) ? ($id[0] ?? null) : $id;

        if (blank($id)) {
            return null;
        }

        $media = Media::find($id);

        return $media?->url;
    }

    private function resolveAdminPanelBrandLogo(): string|Htmlable
    {
        $setting = $this->firstSettingRecord();
        $design = $setting?->design ?? [];

        if (($design['admin_panel_logo_mode'] ?? 'custom') === 'default_app') {
            return asset(self::DEFAULT_ADMIN_PANEL_LOGO);
        }

        $lightUrl = $this->mediaUrlFromDesignId($design['logo'] ?? null);
        $darkUrl = $this->mediaUrlFromDesignId($design['logo_dark_mode'] ?? null);

        if (! $lightUrl && $darkUrl) {
            $lightUrl = $darkUrl;
        }

        if ($lightUrl) {
            return $lightUrl;
        }

        $name = $setting?->application['name'] ?? config('app.name');

        return new HtmlString(
            '<h3 class="m-0 max-w-[14rem] truncate text-lg font-semibold leading-tight tracking-tight text-gray-950 dark:text-white">'
            .e($name)
            .'</h3>'
        );
    }

    private function resolveAdminPanelBrandLogoHeight(): string
    {
        $setting = $this->firstSettingRecord();
        $design = $setting?->design ?? [];

        if (($design['admin_panel_logo_mode'] ?? 'custom') === 'default_app') {
            return '2rem';
        }

        $lightUrl = $this->mediaUrlFromDesignId($design['logo'] ?? null);
        $darkUrl = $this->mediaUrlFromDesignId($design['logo_dark_mode'] ?? null);

        if (! $lightUrl && $darkUrl) {
            $lightUrl = $darkUrl;
        }

        return $lightUrl ? '2rem' : 'auto';
    }

    private function resolveAdminPanelDarkModeBrandLogo(): ?string
    {
        $setting = $this->firstSettingRecord();
        $design = $setting?->design ?? [];

        if (($design['admin_panel_logo_mode'] ?? 'custom') === 'default_app') {
            return null;
        }

        $lightUrl = $this->mediaUrlFromDesignId($design['logo'] ?? null);
        $darkUrl = $this->mediaUrlFromDesignId($design['logo_dark_mode'] ?? null);

        if (! $lightUrl && $darkUrl) {
            $lightUrl = $darkUrl;
        }

        if (! $lightUrl || ! $darkUrl || $darkUrl === $lightUrl) {
            return null;
        }

        return $darkUrl;
    }
}
