<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsInAdminHeaderHook
{
    protected function targetInAdminHeaderHook()
    {
        add_action(
            'in_admin_header',
            $this->getInAdminHeaderCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getInAdminHeaderCallback(): Closure
    {
        return function () {
            $this->doInAdminHeaderAction();
        };
    }

    abstract protected function doInAdminHeaderAction(): void;
}
