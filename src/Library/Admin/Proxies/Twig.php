<?php

namespace Leonidas\Library\Admin\Proxies;

use Leonidas\Library\Core\BaseObjectProxy;
use Twig\Environment;

/** @method static string render($name, array $context = []) */
class Twig extends BaseObjectProxy
{
    public static function _getObjectRoot()
    {
        return Environment::class;
    }
}
