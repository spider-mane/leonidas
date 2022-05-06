<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators\Permissions;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class UserCan extends AbstractUserPermissionsValidator implements ServerRequestPolicyInterface
{
    /**
     * @var string
     */
    protected $capability;

    /**
     * @var array
     */
    protected $args = [];

    public function __construct(string $capability, ...$args)
    {
        $this->capability = $capability;

        $args && $this->args = $args;
    }

    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return $this->args;
    }
}
