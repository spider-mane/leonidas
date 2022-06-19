<?php

declare(strict_types=1);

namespace Leonidas\Console\Library;

use Nette\PhpGenerator\Printer;

class PsrPrinter74 extends Printer
{
    /**
     * @var string
     */
    protected $indentation = '    ';

    /**
     *  @var int
     */
    protected $linesBetweenMethods = 1;

    /**
     *  @var int
     */
    protected $linesBetweenProperties = 1;
}
