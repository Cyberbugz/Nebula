<?php

namespace App\Console\Core\Concerns;

use Symfony\Component\Console\Input\InputOption;

trait OptionsExtender
{
    protected function checkAbsolutePath(): void
    {
        if ($absolute = $this->option('absolute')) {
            config()->set('app.modules_path', ucfirst($absolute));

        }
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
           ['module', 'M', InputOption::VALUE_REQUIRED, 'Specify a module.'],
           ['absolute', 'A', InputOption::VALUE_OPTIONAL, 'Specify absolute modules path.'],
        ]);
    }

    public function handle()
    {
        $this->checkAbsolutePath();
        parent::handle();
    }
}
