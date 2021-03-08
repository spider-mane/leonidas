<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsParentFileHookTrait
{
    protected function targetParentFileHook()
    {
        add_filter(
            'parent_file',
            [$this, 'resolveParentFile'],
            $this->defineParentFileHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineParentFileHookPriority(): ?int
    {
        return null;
    }

    abstract public function resolveParentFile(string $parentFile): string;
}
