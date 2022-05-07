<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAllAdminNoticesHook
{
    protected function targetAllAdminNoticesHook()
    {
        add_action(
            "all_admin_notices",
            Closure::fromCallable([$this, 'doAllAdminNoticesAction']),
            $this->getAllAdminNoticesPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAllAdminNoticesPriority(): int
    {
        return 10;
    }

    abstract protected function doAllAdminNoticesAction(): void;
}
