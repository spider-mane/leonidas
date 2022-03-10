<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Admin\Fields\Factory\Field;
use Psr\Container\ContainerInterface;

class FieldFactoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = [])
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
