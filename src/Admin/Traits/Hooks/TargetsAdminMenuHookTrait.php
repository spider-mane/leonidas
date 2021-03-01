<?php

namespace WebTheory\Leonidas\Admin\Traits\Hooks;

trait TargetsAdminMenuHookTrait
{
    protected function targetAdminMenuHook()
    {
        add_filter(
            'admin_menu',
            [$this, 'doAdminMenuAction'],
            $this->defineAdminMenuHookPriority(),
            $this->defineAdminMenuHookArgCount()
        );

        return $this;
    }

    protected function defineAdminMenuHookArgCount(): int
    {
        return PHP_INT_MAX;
    }

    protected function defineAdminMenuHookPriority(): ?int
    {
        return null;
    }

    abstract public function doAdminMenuAction(string $context): void;
}
