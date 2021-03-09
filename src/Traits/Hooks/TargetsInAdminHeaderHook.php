<?php

namespace WebTheory\Leonidas\Traits\Hooks;

use Closure;

trait TargetsInAdminHeaderHook
{
    protected function targetInAdminHeaderHook(): TargetsInAdminHeaderHook
    {
        add_action('in_admin_header', $this->getInAdminHeaderCallback(), null, PHP_INT_MAX);

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
