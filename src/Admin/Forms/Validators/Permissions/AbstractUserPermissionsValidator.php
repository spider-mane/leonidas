<?php

namespace WebTheory\Leonidas\Admin\Forms\Validators\Permissions;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

abstract class AbstractUserPermissionsValidator implements FormValidatorInterface
{
    /**
     * @var string
     */
    protected $capability;

    /**
     *
     */
    public function isValid(ServerRequestInterface $request): bool
    {
        return current_user_can($this->capability, ...$this->getCapArgs($request));
    }

    /**
     *
     */
    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return [];
    }
}
