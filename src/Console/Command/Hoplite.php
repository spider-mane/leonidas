<?php

namespace Leonidas\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Yaml\Yaml;

class Hoplite extends Command
{
    protected function getConfig(): array
    {
        return Yaml::parseFile(getcwd() . '/hoplite.yml');
    }

    protected function path(string $path): string
    {
        return dirname(__DIR__, 1) . $path;
    }
}
