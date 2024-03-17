<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpImageEditorsHook
{
    protected function targetWpImageEditorsHook()
    {
        add_filter(
            "wp_image_editors",
            Closure::fromCallable([$this, 'filterWpImageEditors']),
            $this->getWpImageEditorsPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpImageEditorsPriority(): int
    {
        return 10;
    }

    abstract protected function filterWpImageEditors(array $imageEditors): array;
}
