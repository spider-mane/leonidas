<?php

namespace Leonidas\Framework\Provider\League;

class PublicFieldFactoryServiceProvider extends FieldFactoryServiceProvider
{
    protected function serviceId(): string
    {
        return 'public_field_factory';
    }

    protected function serviceTags(): array
    {
        return [];
    }
}
