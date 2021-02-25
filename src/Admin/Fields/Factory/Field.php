<?php

namespace WebTheory\Leonidas\Admin\Fields\Factory;

use WebTheory\Saveyour\Contracts\FieldDataManagerResolverFactoryInterface;
use WebTheory\Saveyour\Contracts\FormFieldResolverFactoryInterface;
use WebTheory\Saveyour\Factories\SimpleFieldFactory;

class Field extends SimpleFieldFactory
{
    /**
     *
     */
    protected $controller = WpAdminField::class;

    /**
     *
     */
    protected function defineFormFieldFactory(array $options): FormFieldResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $fields = $options['fields'] ?? [];

        return new FormField($namespaces, $fields);
    }

    /**
     *
     */
    protected function defineDataManagerFactory(array $options): FieldDataManagerResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new DataManager($namespaces, $managers);
    }
}
