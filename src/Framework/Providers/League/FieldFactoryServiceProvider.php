<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\FieldFactoryProvider;
use Leonidas\Library\Admin\Fields\Factory\Field;
use Panamax\Contracts\ServiceFactoryInterface;

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

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new FieldFactoryProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('view.fields');
    }
}
