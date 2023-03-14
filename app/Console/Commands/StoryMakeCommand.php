<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Core\Concerns\OptionsExtender;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:story')]
class StoryMakeCommand extends Command
{
    use OptionsExtender;

    protected $signature = 'make:story {name : name of the story} {module : name of the module}';

    protected $description = 'Create a user story';


    public function handle()
    {
        $name   = $this->argument('name');
        $module = $this->argument('module');
        $this->createController($name, $module);
        $this->createRequest($name, $module);
        $this->createResponse($name, $module);
        $this->createService($name, $module);
        $this->createTest($name, $module);
    }

    protected function createController(string $name, string $module)
    {
        $this->call('make:controller', [
            'name'     => $name,
            '--module' => $module,
        ]);
    }

    protected function createRequest(string $name, string $module)
    {
        $this->call('make:request', [
            'name'     => $name,
            '--module' => $module,
        ]);
    }

    protected function createResponse(string $name, string $module)
    {
        $this->call('make:response', [
            'name'     => $name,
            '--module' => $module,
        ]);
    }

    protected function createService(string $name, string $module)
    {
        $this->call('make:service', [
            'name'     => $name,
            '--module' => $module,
        ]);
    }

    protected function createTest(string $name, string $module)
    {
        $this->call('make:test', [
            'name'     => $name,
            '--module' => $module,
        ]);
    }
}
