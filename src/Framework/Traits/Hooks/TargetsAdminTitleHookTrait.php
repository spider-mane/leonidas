<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsAdminTitleHookTrait
{
    protected function targetAdminTitleHook()
    {
        add_filter(
            'admin_title',
            [$this, 'resolveAdminTitle'],
            $this->defineAdminTitleHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineAdminTitleHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveAdminTitle(string $adminTitle, string $title): string;
}
