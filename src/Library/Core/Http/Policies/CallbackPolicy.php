<?php

namespace Leonidas\Library\Core\Http\Policies;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

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
