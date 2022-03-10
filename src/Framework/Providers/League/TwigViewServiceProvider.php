<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\TwigProvider;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class TwigViewServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return Environment::class;
    }

    protected function serviceTags(): array
    {
        return ['twig', 'views', 'templates'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new TwigProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('twig');
    }
}
