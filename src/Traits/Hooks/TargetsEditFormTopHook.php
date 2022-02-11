<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Post;

trait TargetsEditFormTopHook
{
    protected function targetEditFormTopHook()
    {
        add_action(
            "edit_form_top",
            Closure::fromCallable([$this, 'doEditFormTopAction']),
            $this->getEditFormTopPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getEditFormTopPriority(): int
    {
        return 10;
    }

    abstract protected function doEditFormTopAction(WP_Post $post): void;
}
