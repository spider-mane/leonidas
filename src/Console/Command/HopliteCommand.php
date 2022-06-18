<?php

namespace Leonidas\Console\Command;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleHighlighter\Highlighter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Yaml\Yaml;

abstract class HopliteCommand extends Command
{
    protected function getConfig(): array
    {
        return Yaml::parseFile(getcwd() . '/hoplite.yml');
    }

    protected function path(string $path): string
    {
        return dirname(__DIR__, 1) . $path;
    }

    protected function printPhp(string $code): void
    {
        $highlighter = new Highlighter(new ConsoleColor());

        echo $highlighter->getWholeFile($code);
    }
}
