<?php

namespace Leonidas\Library\System\Request\Policy;

use Leonidas\Library\System\Request\Abstracts\ExpectsPostEntityTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class PostEntityPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostEntityTrait;

    /**
     * @var int[]
     */
    protected array $posts = [];

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
