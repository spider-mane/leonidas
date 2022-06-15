<?php

namespace Leonidas\Framework\Plugin\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionMasterClassTrait;
use Leonidas\Framework\Exception\PluginInitiationException;

trait PluginMasterClassTrait
{
    use ExtensionMasterClassTrait;

    private static function error(string $method): void
    {
        throw new PluginInitiationException(self::$instance->base, $method);
    }
}
