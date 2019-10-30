<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Saveyour\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Saveyour\Contracts\MultiFieldFactoryInterface;
use WebTheory\Saveyour\Field as BaseField;
use WebTheory\Leonidas\Fields\Factory as WpFormFieldFactory;
use WebTheory\Leonidas\Fields\Managers\Factory as WpDataManagerFactory;

class Field extends BaseField
{
    /**
     *
     */
    protected $controller = WpAdminField::class;

    /**
     *
     */
    protected function createFormFieldFactory(array $options): MultiFieldFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $fields = $options['fields'] ?? [];

        return new WpFormFieldFactory($namespaces, $fields);
    }

    /**
     *
     */
    protected function createDataManagerFactory(array $options): MultiFieldDataManagerFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new WpDataManagerFactory($namespaces, $managers);
    }
}
