<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAdminMenuHook
{
    protected function targetAdminMenuHook()
    {
        add_action(
            'admin_menu',
            $this->getAdminMenuCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAdminMenuCallback(): Closure
    {
        return function (string $context) {
            $this->doAdminMenuAction($context);
        };
    }

    abstract protected function doAdminMenuAction(string $context): void;
}
