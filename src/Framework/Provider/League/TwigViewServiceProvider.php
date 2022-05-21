<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\TwigProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Twig\Environment;

class TwigViewServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return Environment::class;
    }

    protected function serviceTags(): array
    {
        return ['twig', 'views', 'templates'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new TwigProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('twig');
    }
}
