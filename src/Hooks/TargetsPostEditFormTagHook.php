<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Post;

trait TargetsPostEditFormTagHook
{
    protected function targetPostEditFormTagHook()
    {
        add_action(
            "post_edit_form_tag",
            Closure::fromCallable([$this, 'doPostEditFormTagAction']),
            $this->getPostEditFormTagPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getPostEditFormTagPriority(): int
    {
        return 10;
    }

    abstract protected function getPostType(): string;

    abstract protected function doPostEditFormTagAction(WP_Post $post): void;
}
