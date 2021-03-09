<?php

namespace WebTheory\Leonidas\Admin\Constrainers;

use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use WebTheory\Leonidas\Traits\ExpectsPostTrait;
use WebTheory\Leonidas\Contracts\Auth\ConstrainerInterface;

class PostConstrainer implements ConstrainerInterface
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
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     *
     */
    public function requestMeetsCriteria(ServerRequestInterface $request): bool
    {
        return in_array($this->getPostId($request), $this->posts);
    }
}
