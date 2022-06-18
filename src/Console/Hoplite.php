<?php

namespace Leonidas\Console;

use Leonidas\Console\Command\Make\HookCommand;
use Leonidas\Console\Command\Make\ModelCollectionCommand;
use Symfony\Component\Console\Application;

class Hoplite
{
    public const COMMANDS = [
        ModelCollectionCommand::class,
        HookCommand::class,
    ];

    public static function init(array $commands = []): void
    {
        $app = new Application('hoplite', '0.1.0');

        array_map(
            fn (string $command) => $app->add(new $command()),
            [...static::COMMANDS, ...$commands]
        );

        $app->run();
    }
}
