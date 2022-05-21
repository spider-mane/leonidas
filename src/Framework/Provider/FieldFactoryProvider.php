<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\Admin\Field\Factory\Field;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class FieldFactoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Field
    {
        return new Field([

            'form_field_factory' => [
                'fields' => $args['form_field']['fields'],
                'namespaces' => $args['form_field']['namespaces'],
            ],

            'data_manager_factory' => [
                'managers' => $args['data_manager']['managers'],
                'namespaces' => $args['data_manager']['namespaces'],
            ],

        ]);
    }
}
