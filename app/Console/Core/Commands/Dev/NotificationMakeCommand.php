<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\NotificationMakeCommand as BaseNotificationMakeCommand;

class NotificationMakeCommand extends BaseNotificationMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($module = $this->option('module'))) {
            return get_module_namespace($rootNamespace, $module,
                [
                    'Manager',
                    'Notifications'
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
