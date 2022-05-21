<?php

namespace Leonidas\Framework\Provider\Abstracts;

use WebTheory\Config\Interfaces\ConfigInterface;

trait ExtensionAwareTrait
{
    protected string $configService = 'config';

    protected function getConfig(string $key, $default = null)
    {
        return $this->config()->get($key, $default);
    }

    abstract protected function config(): ConfigInterface;
}
