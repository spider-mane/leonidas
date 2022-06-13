<?php

namespace Leonidas\Framework\Provider\League;

class PublicFieldFactoryServiceProvider extends FieldFactoryServiceProvider
{
    protected function id(): string
    {
        return 'fields.public';
    }

    protected function types(): array
    {
        return [];
    }

    protected function aliases(): array
    {
        return [];
    }

    protected function args(): ?array
    {
        return $this->getConfig('view.fields');
    }
}
