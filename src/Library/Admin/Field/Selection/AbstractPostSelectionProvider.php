<?php

namespace Leonidas\Library\Admin\Field\Selection;

use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Post;

abstract class AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @param WP_Post $post
     */
    public function defineSelectionValue($post): string
    {
        return (string) $post->ID;
    }
}
