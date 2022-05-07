<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAdminNoticesHook
{
    protected function targetAdminNoticesHook()
    {
        add_action(
            'admin_notices',
            $this->getAdminNoticesCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAdminNoticesCallback(): Closure
    {
        return function () {
            return $this->doAdminNoticesAction();
        };
    }

    abstract protected function doAdminNoticesAction(): void;
}
