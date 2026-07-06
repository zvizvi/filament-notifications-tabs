<?php

namespace Zvizvi\FilamentNotificationsTabs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Zvizvi\FilamentNotificationsTabs\FilamentNotificationsTabs
 */
class FilamentNotificationsTabs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Zvizvi\FilamentNotificationsTabs\FilamentNotificationsTabs::class;
    }
}
