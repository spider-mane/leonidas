<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use InvalidArgumentException;
use Stringable;
use WP_Post;
use WP_Query;

trait ValidatesPostTypeTrait
{
    /**
     * @throws InvalidArgumentException
     */
    protected function assertPostType(WP_Post $post, string $postType): self
    {
        if ($postType !== $actual = $post->post_type) {
            throw new InvalidArgumentException(
                "The post type of the post must be \"{$postType}\", but it is \"{$actual}.\"",
            );
        }

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertPostTypeOnQuery(WP_Query $query, string $postType): self
    {
        $actual = $query->get('post_type', null);

        if (is_array($actual) && count($actual) === 1) {
            $actual = $actual[0];
        } elseif (!is_string($actual)) {
            $actual = null;
        }

        if ($postType !== $actual) {
            if (is_string($actual) || $actual instanceof Stringable) {
                $message = "Query post_type value must be \"{$postType}\", but it is \"{$actual}\".";
            } elseif (is_array($actual) && in_array($postType, $actual, true)) {
                $message = "post_type value for query must be exclusively for \"{$postType}\".";
            } else {
                $message = "Query post_type value must be \"{$postType}\".";
            }

            throw new InvalidArgumentException($message);
        }

        return $this;
    }
}
