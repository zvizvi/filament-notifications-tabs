<a href="https://github.com/zvizvi/filament-notifications-tabs" class="filament-hidden">

![Filament Relation Manager Repeater](https://raw.githubusercontent.com/zvizvi/filament-notifications-tabs/main/.github/banner.png)

</a>

# Filament Notifications Tabs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zvizvi/filament-notifications-tabs.svg?style=flat-square)](https://packagist.org/packages/zvizvi/relation-manager-repeater)
[![Total Downloads](https://img.shields.io/packagist/dt/zvizvi/filament-notifications-tabs.svg?style=flat-square)](https://packagist.org/packages/zvizvi/relation-manager-repeater)

Adds tabs and per-notification actions to the Filament database notifications modal:

- **Unread / All tabs** — filter the notifications list, with an unread-count badge on the Unread tab.
- **Per-notification actions** — replaces the default X (close) button with a delete (trash) button and a toggle read/unread button.

Compatible with Filament v5 panels.

## Installation

Install the package via Composer:

```bash
composer require zvizvi/filament-notifications-tabs:^0.0.2
```

### Register the styles (Tailwind v4)

The modal view uses Tailwind utility classes, so Tailwind needs to scan this package's Blade files. Add a `@source` directive to your Filament theme CSS (e.g. `resources/css/filament/admin/theme.css`), then rebuild:

```css
@source '../../../../vendor/zvizvi/filament-notifications-tabs/resources/views/**/*.blade.php';
```

Adjust the number of `../` to match the location of your theme file relative to `vendor/`.

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

### Confirm before delete

By default, clicking the delete button removes the notification immediately. To require Filament's native confirmation dialog first:

```php
FilamentNotificationsTabsPlugin::make()
    ->confirmDelete()
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
