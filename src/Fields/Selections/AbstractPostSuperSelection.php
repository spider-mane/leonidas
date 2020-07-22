<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractPostSuperSelection implements SuperSelectionProviderInterface
{
    /**
     * @param WP_Post $post
     */
    public function provideItemValue($post): string
    {
        return (string) $post->ID;
    }
}
