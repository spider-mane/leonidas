<?php

namespace Leonidas\Library\System\Post\Policies;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Leonidas\Traits\ExpectsPostTrait;
use Psr\Http\Message\ServerRequestInterface;

class PostPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostTrait;

    /**
     * @var int[]
     */
    protected $posts = [];

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

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return in_array($this->getPostId($request), $this->posts);
    }
}
