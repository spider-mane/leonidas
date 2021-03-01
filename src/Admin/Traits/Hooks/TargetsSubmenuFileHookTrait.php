<?php

namespace WebTheory\Leonidas\Admin\Traits\Hooks;

trait TargetsSubmenuFileHookTrait
{
    protected function targetSubmenuFileHook()
    {
        add_filter(
            'submenu_file',
            [$this, 'resolveSubmenuFile'],
            $this->defineSubmenuFileHookPriority(),
            $this->defineSubmenuFileHookArgCount()
        );

        return $this;
    }

    protected function defineSubmenuFileHookArgCount(): int
    {
        return PHP_INT_MAX;
    }

    protected function defineSubmenuFileHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveSubmenuFile(string $submenuFile, string $parentFile): string;
}
