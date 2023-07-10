<?php

namespace Leonidas\Library\System\Request\Policy;

use Leonidas\Library\System\Request\Abstracts\ExpectsPostEntityTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class PostEntityPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostEntityTrait;

    /**
     * @var array<int>
     */
    protected array $posts;

    public function __construct(int ...$posts)
    {
        $this->posts = $posts;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return in_array($this->getPostId($request), $this->posts);
    }
}
