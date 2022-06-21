<?php

declare(strict_types=1);

namespace Leonidas\Console\Library;

use Nette\PhpGenerator\Printer;

class PsrPrinterFactory
{
    public static function compat3(): Printer
    {
        return new class () extends Printer {
            protected $indentation = '    ';

            protected $linesBetweenMethods = 1;

            protected $linesBetweenProperties = 1;
        };
    }

    public static function compat4(): Printer
    {
        return new class () extends Printer {
            public string $indentation = '    ';

            public int $linesBetweenMethods = 1;

            public int $linesBetweenProperties = 1;
        };
    }
}
