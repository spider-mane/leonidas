<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\Abstracts\ExtensionAwareTrait;
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
