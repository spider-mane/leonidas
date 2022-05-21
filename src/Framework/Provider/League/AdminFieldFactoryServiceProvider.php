<?php

namespace Leonidas\Framework\Provider\League;

class AdminFieldFactoryServiceProvider extends FieldFactoryServiceProvider
{
    protected function serviceId(): string
    {
        return 'admin_field_factory';
    }

    protected function serviceTags(): array
    {
        return [];
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('admin.fields');
    }
}
