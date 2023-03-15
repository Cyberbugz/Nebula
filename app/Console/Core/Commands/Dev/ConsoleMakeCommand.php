<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\ConsoleMakeCommand as BaseConsoleMakeCommand;

class ConsoleMakeCommand extends BaseConsoleMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (! is_null($module = $this->option('module'))) {
            return get_module_namespace($rootNamespace, $module,
                [
                    'Manager',
                    'Commands',
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
