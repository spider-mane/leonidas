<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

trait CanBeRestrictedTrait
{
    protected ?ServerRequestPolicyInterface $policy = null;

    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return !isset($this->policy) || $this->policy->approvesRequest($request);
    }
}
