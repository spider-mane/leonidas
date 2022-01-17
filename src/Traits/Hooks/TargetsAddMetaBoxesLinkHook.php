<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAddMetaBoxesLinkHook
{
    protected function targetAddMetaBoxesLinkHook()
    {
        add_action(
            "add_meta_boxes_link",
            $this->getAddMetaBoxesLinkCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesLinkCallback(): Closure
    {
        return function (object $link) {
            $this->doAddMetaBoxesLinkAction($link);
        };
    }

    abstract protected function doAddMetaBoxesLinkAction(object $link): void;
}
