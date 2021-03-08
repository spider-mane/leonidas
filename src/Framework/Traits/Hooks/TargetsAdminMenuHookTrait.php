<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsAdminMenuHookTrait
{
    protected function targetAdminMenuHook()
    {
        add_filter(
            'admin_menu',
            [$this, 'doAdminMenuAction'],
            $this->defineAdminMenuHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineAdminMenuHookPriority(): ?int
    {
        return null;
    }

    abstract public function doAdminMenuAction(string $context): void;
}
