<?php

declare(strict_types=1);

namespace Leonidas\Console\Library;

use Composer\InstalledVersions;
use Nette\PhpGenerator\Printer;

class PsrPrinterFactory
{
    public static function create(): Printer
    {
        $version = InstalledVersions::getVersion('nette/php-generator');

        return version_compare($version, '4.0', '>=')
            ? self::compat4()
            : self::compat3();
    }

    protected static function compat3(): Printer
    {
        return new class () extends Printer {
            protected $indentation = '    ';

            protected $linesBetweenMethods = 1;

            protected $linesBetweenProperties = 1;
        };
    }

    protected static function compat4(): Printer
    {
        return new class () extends Printer {
            public string $indentation = '    ';

            public int $linesBetweenMethods = 1;

            public int $linesBetweenProperties = 1;
        };
    }
}
