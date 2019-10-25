<?php

namespace WebTheory\Saveyour;

use WebTheory\Saveyour\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Saveyour\Contracts\MultiFieldFactoryInterface;
use WebTheory\Saveyour\DataManagerFactory;
use WebTheory\Saveyour\FieldFactory;

class Field extends FieldFactory
{
    /**
     *
     */
    public function __construct(array $options = [])
    {
        $field = $options['form_field_factory'] ?? [];
        $manager = $options['data_manager_factory'] ?? [];
        $controller = $options['controller'] ?? null;

        $this->formFieldFactory = $this->createFormFieldFactory($field);
        $this->dataManagerFactory = $this->createDataManagerFactory($manager);

        if (isset($controller)) {
            $this->controller = $controller;
        }
    }

    /**
     *
     */
    protected function createFormFieldFactory(array $options): MultiFieldFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $fields = $options['fields'] ?? [];

        return new FormFieldFactory($namespaces, $fields);
    }

    /**
     *
     */
    protected function createDataManagerFactory(array $options): MultiFieldDataManagerFactoryInterface
    {
        $namespaces = $options['namespaces'] ?? [];
        $managers = $options['managers'] ?? [];

        return new DataManagerFactory($namespaces, $managers);
    }
}
