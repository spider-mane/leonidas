<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\FieldFactoryProvider;
use Leonidas\Library\Admin\Fields\Factory\Field;
use Psr\Container\ContainerInterface;

class FieldFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return Field::class;
    }

    protected function serviceTags(): array
    {
        return ['field_factory'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new FieldFactoryProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('view.fields');
    }
}
