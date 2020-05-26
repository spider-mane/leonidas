<?php

namespace WebTheory\Leonidas\Constrainers;

use WP_Post;
use WebTheory\Leonidas\Contracts\ComponentConstrainerInterface;

class PostConstrainer implements ComponentConstrainerInterface
{
    /**
     * @var int[]
     */
    protected $posts = [];

    /**
     *
     */
    public function __construct(int ...$posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the value of posts
     *
     * @return int[]
     */
    public function getPosts(): int
    {
        return $this->posts;
    }

    /**
     *
     */
    public function loadComponentForPost(WP_Post $post)
    {
        return in_array($post->ID, $this->posts);
    }
}
