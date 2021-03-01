<?php

namespace WebTheory\Leonidas\Admin\Traits\Hooks;

trait TargetsAdminTitleHookTrait
{
    protected function targetAdminTitleHook()
    {
        add_filter(
            'admin_title',
            [$this, 'resolveAdminTitle'],
            $this->defineAdminTitleHookPriority(),
            $this->defineAdminTitleHookArgCount()
        );

        return $this;
    }

    protected function defineAdminTitleHookArgCount(): int
    {
        return PHP_INT_MAX;
    }

    protected function defineAdminTitleHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveAdminTitle(string $adminTitle, string $title): string;
}
