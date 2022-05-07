<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Comment;

trait TargetsAddMetaBoxesCommentHook
{
    protected function targetAddMetaBoxesCommentHook()
    {
        add_action(
            "add_meta_boxes_comment",
            $this->getAddMetaBoxesCommentCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesCommentCallback(): Closure
    {
        return function (WP_Comment $comment) {
            $this->doAddMetaBoxesCommentAction($comment);
        };
    }

    abstract protected function doAddMetaBoxesCommentAction(WP_Comment $comment): void;
}
