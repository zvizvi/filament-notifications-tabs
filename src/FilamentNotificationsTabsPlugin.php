<?php

namespace Zvizvi\FilamentNotificationsTabs;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Zvizvi\FilamentNotificationsTabs\Livewire\DatabaseNotifications;

class FilamentNotificationsTabsPlugin implements Plugin
{
    protected string $defaultTab = 'unread';

    protected bool $confirmDelete = false;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-notifications-tabs';
    }

    public function defaultTab(string $tab): static
    {
        $this->defaultTab = $tab;

        return $this;
    }

    public function confirmDelete(bool $condition = true): static
    {
        $this->confirmDelete = $condition;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->databaseNotificationsLivewireComponent(DatabaseNotifications::class);
    }

    public function boot(Panel $panel): void
    {
        DatabaseNotifications::defaultTab($this->defaultTab);
        DatabaseNotifications::confirmDelete($this->confirmDelete);
    }
}
