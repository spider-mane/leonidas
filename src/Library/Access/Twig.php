<?php

namespace Leonidas\Library\Access;

use Twig\Environment;

/** @method static string render($name, array $context = []) */
class Twig extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return Environment::class;
    }
}
