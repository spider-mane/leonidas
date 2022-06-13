<?php

namespace Leonidas\Framework\Provider\League;

class AdminFieldFactoryServiceProvider extends FieldFactoryServiceProvider
{
    protected function id(): string
    {
        return 'fields.admin';
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
        return $this->getConfig('admin.fields');
    }
}
