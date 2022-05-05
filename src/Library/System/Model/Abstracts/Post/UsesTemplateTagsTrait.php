<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Closure;
use Leonidas\Library\Core\Util\OutputBuffer;
use WP_Post;

trait UsesTemplateTagsTrait
{
    protected WP_Post $stashedPostObject;

    protected function stashPostObject(WP_Post $post): void
    {
        $this->stashedPostObject = $post;
    }

    protected function function(callable $function): Closure
    {
        return Closure::fromCallable($function);
    }

    protected function templateTag(callable $tag): Closure
    {
        return fn () => $this->forceTemplateTag($tag);
    }

    protected function forceTemplateTag(callable $tag): string
    {
        $cached = $this->swapGlobalPost($this->stashedPostObject);

        $value = OutputBuffer::wrapFunctionCall($tag);

        $this->restoreGlobalPost($cached);

        return $value;
    }

    protected function swapGlobalPost(WP_Post $replacement): WP_Post
    {
        global $post;

        $cached = $post;

        $post = $replacement;

        return $cached;
    }

    protected function restoreGlobalPost(WP_Post $cached): void
    {
        global $post;

        $post = $cached;
    }
}
