<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsEnqueueBlockEditorAssetsHook
{
    protected function targetEnqueueBlockEditorAssetsHook()
    {
        add_action(
            'enqueue_block_editor_assets',
            $this->getEnqueueBlockEditorAssetsCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getEnqueueBlockEditorAssetsCallback(): Closure
    {
        return function () {
            $this->doEnqueueBlockEditorAssetsAction();
        };
    }

    abstract protected function doEnqueueBlockEditorAssetsAction(): void;
}
