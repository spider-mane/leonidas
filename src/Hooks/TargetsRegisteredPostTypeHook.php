<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Post_Type;

trait TargetsRegisteredPostTypeHook
{
    protected function targetRegisteredPostTypeHook()
    {
        add_action(
            "registered_post_type",
            Closure::fromCallable([$this, 'doRegisteredPostTypeAction']),
            $this->getRegisteredPostTypePriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getRegisteredPostTypePriority(): int
    {
        return 10;
    }

    abstract protected function doRegisteredPostTypeAction(string $postType, WP_Post_Type $postTypeObject): void;
}
