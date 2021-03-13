<?php

namespace Leonidas\Library\Admin\Proxies;

use Leonidas\Library\Core\Proxies\BaseStaticObjectProxy;
use Twig\Environment;

/** @method static string render($name, array $context = []) */
class Twig extends BaseStaticObjectProxy
{
    public static function _getObjectRoot()
    {
        return Environment::class;
    }
}
