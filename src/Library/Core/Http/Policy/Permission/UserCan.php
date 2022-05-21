<?php

namespace Leonidas\Library\Core\Http\Policy\Permission;

use Leonidas\Library\Core\Http\Policy\Permission\Abstracts\AbstractUserPermission;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class UserCan extends AbstractUserPermission implements ServerRequestPolicyInterface
{
    /**
     * @var string
     */
    protected $capability;

    protected array $args = [];

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
