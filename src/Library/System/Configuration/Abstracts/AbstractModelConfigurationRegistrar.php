<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Configuration\ModelConfigurationInterface;
use UnexpectedValueException;

abstract class AbstractModelConfigurationRegistrar
{
    protected function unregisteredOptionException(string $option): UnexpectedValueException
    {
        return new UnexpectedValueException(
            "There is no registered handler for option \"{$option}\" provided."
        );
    }

    protected function getBaseArgs(ModelConfigurationInterface $type): array
    {
        return [
            // info
            'description' => $type->getDescription(),

            // core
            'capabilities' => $type->getCapabilities(),
            'public' => $type->isPublic(),
            'hierarchical' => $type->isHierarchical(),

            // REST
            'show_in_rest' => $type->isAllowedInRest(),
            'rest_base' => $type->getRestBase(),
            'rest_namespace' => $type->getRestNamespace(),
            'rest_controller_class' => $type->getRestControllerClass(),

            // front
            'publicly_queryable' => $type->isPubliclyQueryable(),
            'query_var' => $type->getQueryVar(),
            'rewrite' => $type->getRewrite(),

            // admin
            'labels' => $type->getLabels(),
            'show_ui' => $type->isAllowedInUi(),
            'show_in_nav_menus' => $type->isAllowedInNavMenus(),
        ];
    }
}
