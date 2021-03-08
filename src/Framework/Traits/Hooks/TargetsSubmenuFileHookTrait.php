<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsSubmenuFileHookTrait
{
    protected function targetSubmenuFileHook()
    {
        add_filter(
            'submenu_file',
            [$this, 'resolveSubmenuFile'],
            $this->defineSubmenuFileHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineSubmenuFileHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveSubmenuFile(string $submenuFile, string $parentFile): string;
}
