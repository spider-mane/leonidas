<?php

namespace Leonidas\Framework\Providers\League;

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
