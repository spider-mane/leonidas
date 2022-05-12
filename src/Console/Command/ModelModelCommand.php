<?php

namespace Leonidas\Console\Command;

use Symfony\Component\Console\Input\InputArgument;

class ModelModelCommand extends Hoplite
{
    protected static $defaultName = 'make:model';

    protected function configure()
    {
        $this
            ->addArgument('model', InputArgument::REQUIRED);
    }
}
