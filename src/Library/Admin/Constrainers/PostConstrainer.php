<?php

namespace Leonidas\Library\Admin\Constrainers;

use Leonidas\Contracts\Auth\ConstrainerInterface;
use Leonidas\Traits\ExpectsPostTrait;
use Psr\Http\Message\ServerRequestInterface;

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
