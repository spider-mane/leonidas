<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\TwigProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Twig\Environment;

class TwigViewServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'twig';
    }

    protected function types(): array
    {
        return [Environment::class];
    }

    protected function aliases(): array
    {
        return ['views', 'templates'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new TwigProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('twig');
    }
}
