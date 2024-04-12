<?php

namespace Leonidas\Library\Admin\Field\Factory;

use WebTheory\Saveyour\Contracts\Factory\FieldDataManagerResolverFactoryInterface;
use WebTheory\Saveyour\Contracts\Factory\FormFieldResolverFactoryInterface;
use WebTheory\Saveyour\Factory\FieldFactory;

class Field extends FieldFactory
{
    protected function defineFormFieldFactory(array $options): FormFieldResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $fields = $options['fields'] ?? [];

        return new FormField($namespaces, $fields);
    }

    protected function defineDataManagerFactory(array $options): FieldDataManagerResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new DataManager($namespaces, $managers);
    }
}
