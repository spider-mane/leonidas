<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

abstract class AbstractPostSelectionProvider extends AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @param WP_Post $post
     */
    public function defineSelectionValue($post): string
    {
        return (string) $post->ID;
    }
}
