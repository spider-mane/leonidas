<?php

namespace Leonidas\Library\Core\Http\Policy\Permission;

use Leonidas\Library\Core\Http\Policy\Permission\Abstracts\AbstractUserPermission;
use Psr\Http\Message\ServerRequestInterface;

class EditPage extends AbstractUserPermission
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_page';

    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return [$request->getAttribute('post_id')];
    }
}
