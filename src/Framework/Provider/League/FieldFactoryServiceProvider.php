<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\FieldFactoryProvider;
use Leonidas\Library\Admin\Field\Factory\Field;
use Panamax\Contracts\ServiceFactoryInterface;

class FieldFactoryServiceProvider extends AbstractLeagueServiceFactory
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
