<?php

namespace App\Console\Core\Concerns;

use Symfony\Component\Console\Input\InputOption;

trait OptionsExtender
{
    use AbsolutePathChecker;

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['module', 'M', InputOption::VALUE_REQUIRED, 'Specify a module.'],
            ['absolute', 'A', InputOption::VALUE_OPTIONAL, 'Specify absolute modules path.'],
            ['guard', 'G', InputOption::VALUE_OPTIONAL, 'Specify guard environment.'],
        ]);
    }

    public function handle(): void
    {
        $this->checkAbsolutePath();
        parent::handle();
    }
}
