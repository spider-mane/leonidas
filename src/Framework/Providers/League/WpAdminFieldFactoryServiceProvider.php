<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WebTheory\Leonidas\Fields\Field;

class WpAdminFieldFactoryServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [Field::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Field::class, function () use ($container) {
            $config = $container->get('config');

            return new Field([

                'form_field_factory' => [
                    'fields' => $config->get('wp.options.form_field.fields'),
                    'namespaces' => $config->get('wp.options.form_field.namespaces'),
                ],

                'data_manager_factory' => [
                    'managers' => $config->get('wp.options.data_manager.managers'),
                    'namespaces' => $config->get('wp.options.data_manager.namespaces'),
                ],
            ]);
        });
    }
}
