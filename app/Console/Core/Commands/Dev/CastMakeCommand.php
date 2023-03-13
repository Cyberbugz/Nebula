<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\CastMakeCommand as BaseCastMakeCommand;

class CastMakeCommand extends BaseCastMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($module = $this->option('module'))) {
            return get_module_namespace($rootNamespace, $module,
                [
                    'Domain',
                    'Casts'
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
