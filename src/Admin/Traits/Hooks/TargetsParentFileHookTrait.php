<?php

namespace WebTheory\Leonidas\Admin\Traits\Hooks;

trait TargetsParentFileHookTrait
{
    protected function targetParentFileHook()
    {
        add_filter(
            'parent_file',
            [$this, 'resolveParentFile'],
            $this->defineParentFileHookPriority(),
            $this->defineParentFileHookArgCount()
        );

        return $this;
    }

    protected function defineParentFileHookArgCount(): int
    {
        return PHP_INT_MAX;
    }

    protected function defineParentFileHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveParentFile(string $parentFile): string;
}
