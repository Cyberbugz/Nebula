<?php

namespace App\Console\Core\Commands\Dev;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use App\Console\Core\Concerns\ModelQualifier;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'make:repository')]
class RepositoryMakeCommand extends GeneratorCommand
{
    use ModelQualifier;

    protected $name = 'make:repository';

    protected $description = 'Create a new model repository';

    protected $type = 'Repository';

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/repository.stub');
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function buildClass($name): array|string
    {
        $repository = class_basename(Str::ucfirst(str_replace('Repository', '', $name)));

        $namespaceModel = $this->qualifyModel($this->argument('model'));

        $model = class_basename($namespaceModel);

        $namespace = get_module_namespace($this->rootNamespace(), $this->argument('module'), [
            'Domain', 'Repositories',
        ]);

        $replace = [
            '{{ repositoryNamespace }}' => $namespace,
            'NamespacedDummyModel'      => $namespaceModel,
            '{{ namespacedModel }}'     => $namespaceModel,
            '{{namespacedModel}}'       => $namespaceModel,
            'DummyModel'                => $model,
            '{{ model }}'               => $model,
            '{{ modelVariable }}'       => lcfirst($model),
            '{{model}}'                 => $model,
            '{{ repository }}'          => $repository,
            '{{repository}}'            => $repository,
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function getPath($name): string
    {
        $module = $this->argument('module');
        $name   = (string)Str::of($name)->replaceFirst(get_module_namespace($this->laravel->getNamespace(), $module, [
            'Domain', 'Repositories',
        ]), '')->finish('Repository');
        if (str_starts_with($name, '\\')) {
            $name = str_replace('\\', '', $name);
        }

        return get_module_path($module, ['Domain', 'Repositories', "$name.php"]);
    }

    protected function guessModelName($name): array|string
    {
        if (str_ends_with($name, 'Repository')) {
            $name = substr($name, 0, -7);
        }

        $modelName = $this->qualifyModel(Str::after($name, $this->rootNamespace()));

        if (class_exists($modelName)) {
            return $modelName;
        }

        $names = explode('\\', $modelName);

        $modelName = array_pop($names);

        return get_module_namespace($this->rootNamespace(), $this->argument('module'), [
            'Domain', 'Entities', $modelName,
        ]);
    }

    protected function getArguments(): array
    {
        return array_merge(parent::getArguments(), [
            ['model', InputArgument::REQUIRED, 'The name of the model'],
            ['module', InputArgument::REQUIRED, 'The name of the module'],
        ]);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return get_module_namespace($this->laravel->getNamespace(), $this->argument('module'),
            [
                'Domain',
                'Repositories',
            ]
        );
    }
}
