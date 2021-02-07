<?php

namespace WebTheory\Leonidas\Admin\Constrainers;

use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use WebTheory\Leonidas\Admin\Contracts\ComponentConstrainerInterface;
use WebTheory\Leonidas\Admin\Traits\ExpectsPostTrait;

class PostConstrainer implements ComponentConstrainerInterface
{
    use ExpectsPostTrait;

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
    public function screenMeetsCriteria(ServerRequestInterface $request): bool
    {
        return in_array($this->getPostId($request), $this->posts);
    }
}
