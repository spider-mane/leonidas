<?php

namespace Leonidas\Library\System;

use Leonidas\Contracts\System\BaseSystemModelTypeInterface;
use UnexpectedValueException;

abstract class AbstractSystemModelTypeRegistrar
{
    protected function unregisteredOptionException(string $option): UnexpectedValueException
    {
        return new UnexpectedValueException(
            "There is no registered handler for option \"{$option}\" provided."
        );
    }

    protected function getBaseArgs(BaseSystemModelTypeInterface $type): array
    {
        return [
            'labels' => $type->getLabels(),
            'description' => $type->getDescription(),
            'public' => $type->isPublic(),
            'hierarchical' => $type->isHierarchical(),
            'publicly_queryable' => $type->isPubliclyQueryable(),
            'show_ui' => $type->isShownInUi(),
            'show_in_menu' => $type->getShownInMenu(),
            'show_in_nav_menus' => $type->isShownInNavMenus(),
            'capabilities' => $type->getCapabilities(),
            'rewrite' => $type->getRewrite(),
            'query_var' => $type->getQueryVar(),
            'show_in_rest' => $type->isShownInRest(),
            'rest_base' => $type->getRestBase(),
            'rest_namespace' => $type->getRestNamespace(),
            'rest_controller_class' => $type->getRestControllerClass(),
        ];
    }
}
