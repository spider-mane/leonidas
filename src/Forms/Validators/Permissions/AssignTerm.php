<?php

namespace WebTheory\Leonidas\Forms\Validators\Permissions;

use Psr\Http\Message\ServerRequestInterface;

class AssignTerm extends AbstractUserPermissionsValidator
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'assign_term';

    /**
     * {@inheritDoc}
     */
    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return [$request->getAttribute('term_id')];
    }
}
