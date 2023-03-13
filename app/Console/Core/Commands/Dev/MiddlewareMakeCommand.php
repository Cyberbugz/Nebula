<?php

namespace App\Console\Core\Commands\Dev;

use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Routing\Console\MiddlewareMakeCommand as BaseMiddlewareMakeCommand;

class MiddlewareMakeCommand extends BaseMiddlewareMakeCommand
{
    use OptionsExtender;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($targetModule = $this->input->getOption('module'))) {
            return get_module_namespace($rootNamespace, $targetModule,
                [
                    'Http',
                    'Middleware'
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
