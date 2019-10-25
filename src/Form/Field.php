<?php

namespace WebTheory\Form;

use WebTheory\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Form\Contracts\MultiFieldFactoryInterface;
use WebTheory\Form\DataManagerFactory;
use WebTheory\Form\FieldFactory;

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
