<?php

namespace WebTheory\Leonidas\Admin\Forms\Validators\Permissions;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Forms\Validators\Permissions\AbstractUserPermissionsValidator;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class UserPermissionsValidator extends AbstractUserPermissionsValidator implements FormValidatorInterface
{
    /**
     * @var string
     */
    protected $capability;

    /**
     * @var array
     */
    protected $args = [];

    /**
     *
     */
    public function __construct(string $capability, ...$args)
    {
        $this->capability = $capability;

        $args && $this->args = $args;
    }

    /**
     *
     */
    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return $this->args;
    }
}
