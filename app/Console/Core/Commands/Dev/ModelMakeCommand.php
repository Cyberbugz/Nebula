<?php

namespace App\Console\Core\Commands\Dev;

use Illuminate\Support\Str;
use App\Console\Core\Concerns\OptionsExtender;
use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;

class ModelMakeCommand extends BaseModelMakeCommand
{
    use OptionsExtender;

    protected string|null $module;

    public function handle()
    {
        $this->module = $this->option('module');
        return parent::handle();
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (!is_null($this->module)) {
            return get_module_namespace($rootNamespace, $this->module, ['Domain', 'Entities']);
        }
        return parent::getDefaultNamespace($rootNamespace);
    }

    protected function createFactory()
    {
        $factory = Str::studly($this->argument('name'));
        $arguments = [
            'name' => "{$factory}Factory",
        ];

        if ($this->module) {
            $arguments['--module'] = $this->module;
        }
        $this->call('make:factory', $arguments);
    }

    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $arguments = [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--fullpath' => true,
        ];

        if ($this->module) {
            $arguments['--module'] = $this->module;
        }

        $this->call('make:migration', $arguments);
    }

    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $arguments = [
            'name' => "{$seeder}Seeder",
        ];

        if ($this->module) {
            $arguments['--module'] = $this->module;
        }

        $this->call('make:seeder', $arguments);
    }

    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $arguments = [
            'name' => "{$controller}Controller",
            '--model' => ($this->option('resource') || $this->option('api')) && !$this->module ? $modelName : null,
            '--api' => $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'),
        ];

        if ($this->module) {
            $arguments['--module'] = $this->module;
        }

        $this->call('make:controller', array_filter($arguments));
    }

    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $arguments = [
            'name' => "{$policy}Policy",
            '--model' => '\\' . $this->qualifyClass($this->getNameInput()),
        ];

        if ($this->module) {
            $arguments['--module'] = $this->module;
        }

        $this->call('make:policy', $arguments);
    }
}
