<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\NotificationMakeCommand as BaseNotificationMakeCommand;

class NotificationMakeCommand extends BaseNotificationMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($targetModule = $this->input->getOption('module'))) {
            return get_module_namespace($rootNamespace, $targetModule,
                [
                    'Manager',
                    'Notifications'
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
