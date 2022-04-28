<?php

namespace Leonidas\Library\System\Schema\Post\Traits;

use InvalidArgumentException;
use WP_Post;

trait ValidatesPostTypeTrait
{
    protected function validatePostType(WP_Post $post): void
    {
        if ($expected = $this->associatedPostType() !== $actual = $post->post_type) {
            throw new InvalidArgumentException(
                "The post type of the post must be \"{$expected}\", but it is \"{$actual}.\"",
            );
        }
    }

    abstract protected function associatedPostType(): string;
}
