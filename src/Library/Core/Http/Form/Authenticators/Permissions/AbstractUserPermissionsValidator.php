<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators\Permissions;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

abstract class AbstractUserPermissionsValidator implements ServerRequestPolicyInterface
{
    /**
     * @var string
     */
    protected $capability;

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return current_user_can($this->capability, ...$this->getCapArgs($request));
    }

    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return [];
    }
}
