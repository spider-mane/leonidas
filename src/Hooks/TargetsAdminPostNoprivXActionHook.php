<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAdminPostNoprivXActionHook
{
    protected function targetAdminPostNoprivXActionHook()
    {
        add_action(
            "admin_post_nopriv_{$this->getAction()}",
            Closure::fromCallable([$this, 'doAdminPostNoprivXActionAction']),
            $this->getAdminPostNoprivXActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAdminPostNoprivXActionPriority(): int
    {
        return 10;
    }

    abstract protected function getAction(): string;

    abstract protected function doAdminPostNoprivXActionAction(): void;
}
