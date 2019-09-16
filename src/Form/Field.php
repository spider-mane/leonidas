<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\Contracts\MultiFieldFactoryInterface;
use Backalley\Form\DataManagerFactory;
use Backalley\Form\FieldFactory;

class Field extends FieldFactory
{
    /**
     *
     */
    public static function bootstrap(array $options = [])
    {
        $formFieldFactory = static::createFormFieldFactory($options['field_factory'] ?? [])
            ->addNamespaces($options['field_factory']['namespace'] ?? [])
            ->addFields($options['field_factory']['fields'] ?? []);

        $dataManagerFactory = static::createDataManagerFactory($options['manager_factory'] ?? [])
            ->addNamespaces($options['manager_factory']['namespace'] ?? [])
            ->addManagers($options['manager_factory']['managers'] ?? []);

        $controller = $options['controller'] ?? null;

        return (new static($formFieldFactory, $dataManagerFactory, $controller));
    }

    /**
     *
     */
    protected static function createFormFieldFactory(array $options): MultiFieldFactoryInterface
    {
        return new FormFieldFactory;
    }

    /**
     *
     */
    protected static function createDataManagerFactory(array $options): MultiFieldDataManagerFactoryInterface
    {
        return new DataManagerFactory;
    }
}
