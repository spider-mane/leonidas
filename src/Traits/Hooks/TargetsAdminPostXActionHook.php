<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAdminPostXActionHook
{
    protected function targetAdminPostXActionHook()
    {
        add_action(
            "admin_post_{$this->getAction()}",
            Closure::fromCallable([$this, 'doAdminPostXActionAction']),
            $this->getAdminPostXActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAdminPostXActionPriority(): int
    {
        return 10;
    }

    abstract protected function getAction(): string;

    abstract protected function doAdminPostXActionAction(): void;
}
