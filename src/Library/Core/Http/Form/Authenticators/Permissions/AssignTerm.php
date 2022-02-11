<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators\Permissions;

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
