<?php

namespace Leonidas\Framework\Provider\League\Abstracts;

use Leonidas\Framework\Provider\Abstracts\ExtensionAwareTrait;
use Panamax\Providers\League\AbstractLeagueServiceProvider as PanamaxAbstractLeagueServiceProvider;
use WebTheory\Config\Interfaces\ConfigInterface;

abstract class AbstractLeagueServiceProvider extends PanamaxAbstractLeagueServiceProvider
{
    use ExtensionAwareTrait;

    protected function config(): ConfigInterface
    {
        return $this->container->get($this->configService);
    }
}
