<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\ResourceMakeCommand as BaseResourceMakeCommand;

class ResourceMakeCommand extends BaseResourceMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($targetModule = $this->input->getOption('module'))) {
            return get_module_namespace($rootNamespace, $targetModule,
                [
                    'Http',
                    'Resources'
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
