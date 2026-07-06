<?php

namespace Zvizvi\FilamentNotificationsTabs;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Zvizvi\FilamentNotificationsTabs\Livewire\DatabaseNotifications;

class FilamentNotificationsTabsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-notifications-tabs';

    public static string $viewNamespace = 'filament-notifications-tabs';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasViews(static::$viewNamespace);
    }

    public function packageBooted(): void
    {
        Livewire::component('filament-notifications-tabs.database-notifications', DatabaseNotifications::class);
    }
}
