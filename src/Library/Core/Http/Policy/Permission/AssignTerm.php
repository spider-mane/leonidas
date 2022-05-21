<?php

namespace Leonidas\Library\Core\Http\Policy\Permission;

use Leonidas\Library\Core\Http\Policy\Permission\Abstracts\AbstractUserPermission;
use Psr\Http\Message\ServerRequestInterface;

class AssignTerm extends AbstractUserPermission
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
