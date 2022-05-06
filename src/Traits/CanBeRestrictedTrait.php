<?php

namespace Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

trait CanBeRestrictedTrait
{
    protected ?ServerRequestPolicyInterface $policy = null;

    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return !isset($this->policy) || $this->policy->approvesRequest($request);
    }
}
