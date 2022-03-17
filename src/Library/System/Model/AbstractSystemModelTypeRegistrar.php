<?php

namespace Leonidas\Library\System\Model;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeInterface;
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
            'show_ui' => $type->isAllowedInUi(),
            'show_in_menu' => $type->getDisplayedInMenu(),
            'show_in_nav_menus' => $type->isAllowedInNavMenus(),
            'capabilities' => $type->getCapabilities(),
            'rewrite' => $type->getRewrite(),
            'query_var' => $type->getQueryVar(),
            'show_in_rest' => $type->isAllowedInRest(),
            'rest_base' => $type->getRestBase(),
            'rest_namespace' => $type->getRestNamespace(),
            'rest_controller_class' => $type->getRestControllerClass(),
        ];
    }
}
