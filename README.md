# Filament Notifications Tabs

Adds tabs and per-notification actions to the Filament database notifications modal:

- **Unread / All tabs** — filter the notifications list, with an unread-count badge on the Unread tab.
- **Per-notification actions** — replaces the default X (close) button with a delete (trash) button and a toggle read/unread button.

Compatible with Filament v5 panels.

## Installation

This package is distributed via GitHub (not Packagist), so add the VCS repository to your `composer.json` first:

```json
{
    "repositories": {
        "notifications-tabs": {
            "type": "vcs",
            "url": "https://github.com/zvizvi/filament-notifications-tabs.git"
        }
    }
}
```

Then require it:

```bash
composer require zvizvi/filament-notifications-tabs:^1.0
```

## Usage

Register the plugin in your panel provider. Database notifications must be enabled on the panel:

```php
use Zvizvi\FilamentNotificationsTabs\FilamentNotificationsTabsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->databaseNotifications()
        ->plugins([
            FilamentNotificationsTabsPlugin::make(),
        ]);
}
```

### Default tab

The modal opens on the **Unread** tab by default. To open on the **All** tab instead:

```php
FilamentNotificationsTabsPlugin::make()
    ->defaultTab('all')
```

## Translations

The package ships with `en` and `he` translations. To customize them:

```bash
php artisan vendor:publish --tag=filament-notifications-tabs-translations
```

## Views

To customize the modal view:

```bash
php artisan vendor:publish --tag=filament-notifications-tabs-views
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
