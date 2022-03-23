<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use WP_Post;

class PostCollection implements PostCollectionInterface
{
    /**
     * @var PostInterface[]
     */
    protected array $posts;

    public function __construct(PostInterface ...$posts)
    {
        $this->posts = $posts;
    }

    public function all(): array
    {
        return $this->posts;
    }

    public static function fromLegacy(WP_Post ...$posts): PostCollectionInterface
    {
        return new self(...array_map(
            fn (WP_Post $post) => new Post($post),
            $posts
        ));
    }
}
