<?php

namespace Leonidas\Console;

use Leonidas\Console\Command\Make\HookCommand;
use Leonidas\Console\Command\Make\ModelCommand;
use Symfony\Component\Console\Application;

class Hoplite
{
    public const COMMANDS = [
        ModelCommand::class,
        HookCommand::class,
    ];

    public static function init(array $commands = []): void
    {
        $app = new Application('Hoplite', '0.1.0');

        array_map(
            fn (string $command) => $app->add(new $command()),
            [...static::COMMANDS, ...$commands]
        );

        $app->run();
    }
}
