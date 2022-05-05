<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use InvalidArgumentException;
use WP_Post;

trait ValidatesPostTypeTrait
{
    protected function validatePostType(WP_Post $post, string $postType): void
    {
        if ($expected = $postType !== $actual = $post->post_type) {
            throw new InvalidArgumentException(
                "The post type of the post must be \"{$expected}\", but it is \"{$actual}.\"",
            );
        }
    }
}
