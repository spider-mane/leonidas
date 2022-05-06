<?php

namespace Leonidas\Library\Core\Http\Policies;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class CallbackPolicy implements ServerRequestPolicyInterface
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return ($this->callback)($request);
    }
}
