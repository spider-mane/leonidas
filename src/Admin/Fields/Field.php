<?php

namespace WebTheory\Leonidas\Admin\Fields;

use WebTheory\Leonidas\Admin\Fields\Factory as WpFormFieldFactory;
use WebTheory\Leonidas\Admin\Fields\Managers\Factory as WpDataManagerFactory;
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

        return new WpFormFieldFactory($namespaces, $fields);
    }

    /**
     *
     */
    protected function defineDataManagerFactory(array $options): FieldDataManagerResolverFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new WpDataManagerFactory($namespaces, $managers);
    }
}
