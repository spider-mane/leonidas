<?php

namespace Leonidas\Framework\Providers\Traits;

use WebTheory\Config\Interfaces\ConfigInterface;

trait ExtensionAwareTrait
{
    protected const CONFIG_SERVICE = 'config';

    final protected function getConfig(string $key, $default = null)
    {
        return $this->config()->get($key, $default);
    }

    abstract protected function config(): ConfigInterface;
}
