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
        $this->createTest($name, $module);
    }

    protected function createController(string $name, string $module)
    {
        $this->call('make:controller', [
            'name'     => $name,
            '--module' => $module,
            '--all' => true,
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
