<?php

namespace Leonidas\Plugin;

use Leonidas\Framework\Plugin\Abstracts\PluginMasterClassTrait;

final class Leonidas
{
    use PluginMasterClassTrait;

    public function service(string $service): object
    {
        return $this->base->get($service);
    }

    public static function getService(string $service): object
    {
        return static::instance()->service($service);
    }
}
