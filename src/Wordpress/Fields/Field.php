<?php

namespace Backalley\WordPress\Fields;

use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\Contracts\MultiFieldFactoryInterface;
use Backalley\Form\Field as BaseField;
use Backalley\WordPress\Fields\Factory as WpFormFieldFactory;
use Backalley\WordPress\Fields\Managers\Factory as WpDataManagerFactory;

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
