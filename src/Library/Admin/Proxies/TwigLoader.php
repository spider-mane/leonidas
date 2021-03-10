<?php

namespace Leonidas\Library\Admin\Proxies;

use Twig\Environment;
use Leonidas\BaseObjectProxy;

/** @method static string render($name, array $context = []) */
class TwigLoader extends BaseObjectProxy
{
    public static function _getObjectRoot()
    {
        return Environment::class;
    }
}
