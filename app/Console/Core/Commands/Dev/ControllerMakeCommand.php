<?php

namespace App\Console\Core\Commands\Dev;

use Illuminate\Support\Str;
use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Routing\Console\ControllerMakeCommand as BaseControllerMakeCommand;

class ControllerMakeCommand extends BaseControllerMakeCommand
{
    use OptionsExtender;

    protected function getPath($name): string
    {
        if (!is_null($module = $this->option('module'))) {
            $name = (string) Str::of($name)->replaceFirst(get_module_namespace($this->laravel->getNamespace(), $module, ['Http', 'Controllers']), '')->finish('Controller');
            if (str_starts_with($name, '\\')) {
                $name = str_replace('\\', '', $name);
            }

            return get_module_path($module, ['Http', 'Controllers', "$name.php"]);
        }

        return parent::getPath($name);
    }

    protected function getStub(): string
    {
        if (!is_null($this->option('module'))) {
            return $this->resolveStubPath('/stubs/controller.module.stub');
        }
        return parent::getStub();
    }
    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($module = $this->option('module'))) {
            return get_module_namespace($rootNamespace, $module, ['Http', 'Controllers']);
        }
        return parent::getDefaultNamespace($rootNamespace);
    }

    protected function qualifyClass($name): string
    {
        $name = (string) Str::of($name)->ucfirst()->finish('Controller');
        return parent::qualifyClass($name);
    }
}
