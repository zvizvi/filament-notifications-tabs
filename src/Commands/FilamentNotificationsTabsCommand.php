<?php

namespace Zvizvi\FilamentNotificationsTabs\Commands;

use Illuminate\Console\Command;

class FilamentNotificationsTabsCommand extends Command
{
    public $signature = 'filament-notifications-tabs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
