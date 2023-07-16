<?php

declare(strict_types=1);

namespace Leonidas\Tasks\Make;

use Nette\PhpGenerator\Printer;

class PsrPrinterFactory
{
    public static function create(): Printer
    {
        return new class () extends Printer {
            public string $indentation = '    ';

            public int $linesBetweenMethods = 1;

            public int $linesBetweenProperties = 1;

            public int $linesBetweenUseTypes = 1;
        };
    }
}
