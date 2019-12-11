<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Leonidas\Fields\Factory as WpFormFieldFactory;
use WebTheory\Leonidas\Fields\Managers\Factory as WpDataManagerFactory;
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
    protected function createFormFieldFactory(array $options): FormFieldResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $fields = $options['fields'] ?? [];

        return new WpFormFieldFactory($namespaces, $fields);
    }

    /**
     *
     */
    protected function createDataManagerFactory(array $options): FieldDataManagerResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new WpDataManagerFactory($namespaces, $managers);
    }
}
