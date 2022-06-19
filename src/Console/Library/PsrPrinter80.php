<?php

declare(strict_types=1);

namespace Leonidas\Console\Library;

use Nette\PhpGenerator\Printer;

class PsrPrinter80 extends Printer
{
    public string $indentation = '    ';

    public int $linesBetweenMethods = 1;

    public int $linesBetweenProperties = 1;
}
