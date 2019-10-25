<?php

namespace WebTheory\WordPress\Fields;

use WebTheory\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Form\Contracts\MultiFieldFactoryInterface;
use WebTheory\Form\Field as BaseField;
use WebTheory\WordPress\Fields\Factory as WpFormFieldFactory;
use WebTheory\WordPress\Fields\Managers\Factory as WpDataManagerFactory;

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
