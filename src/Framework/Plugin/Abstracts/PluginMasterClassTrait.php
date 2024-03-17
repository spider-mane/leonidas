<?php

namespace Leonidas\Framework\Plugin\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionMasterClassTrait;
use Leonidas\Framework\Exception\PluginInitiationException;

trait PluginMasterClassTrait
{
    use ExtensionMasterClassTrait;

    private static function initError(string $method): PluginInitiationException
    {
        return new PluginInitiationException(self::$instance->base, $method);
    }
}
