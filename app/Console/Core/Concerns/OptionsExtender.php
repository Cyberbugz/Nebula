<?php

namespace App\Console\Core\Concerns;

use Symfony\Component\Console\Input\InputOption;

trait OptionsExtender
{
    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
           ['module', 'M', InputOption::VALUE_REQUIRED, 'Specify a module.']
        ]);
    }
}
