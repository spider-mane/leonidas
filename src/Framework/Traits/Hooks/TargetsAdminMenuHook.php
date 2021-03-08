<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

use Closure;

trait TargetsAdminMenuHook
{
    protected function targetAdminMenuHook(): TargetsAdminMenuHook
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
