<?php

namespace App\Console\Core\Commands\Dev;

use Illuminate\Support\Str;
use App\Console\Core\Concerns\OptionsExtender;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Console\TestMakeCommand as BaseTestMakeCommand;

class TestMakeCommand extends BaseTestMakeCommand
{
    use OptionsExtender {
        getOptions as concernGetOptions;
    }

    protected function getPath($name): string
    {
        if (!is_null($module = $this->option('module'))) {
            $name = (string) Str::of($name)->replaceFirst(get_module_namespace($this->laravel->getNamespace(), $module, ['Tests', $this->option('unit') ? 'Unit': 'Feature']), '')->finish('Test');
            if (str_starts_with($name, '\\')) {
                $name = str_replace('\\', '', $name);
            }

            return get_module_path($module, ['Tests', $this->option('unit') ? 'Unit': 'Feature', "$name.php"]);
        }

        return parent::getPath($name);
    }

    protected function rootNamespace(): string
    {
        if (!is_null($this->input->getOption('module'))) {
            return 'App';
        }

        return parent::rootNamespace();
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($targetModule = $this->input->getOption('module'))) {
            return get_module_namespace($rootNamespace, $targetModule,
                [
                    'Tests',
                    $this->option('unit') ? 'Unit': 'Feature',
                ]
            );
        }

        return parent::getDefaultNamespace($rootNamespace);
    }

    protected function qualifyClass($name): string
    {
        $name = (string) Str::of($name)->ucfirst()->finish('Test');
        return parent::qualifyClass($name);
    }
}
