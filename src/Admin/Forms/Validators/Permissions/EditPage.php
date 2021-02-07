<?php

namespace WebTheory\Leonidas\Admin\Forms\Validators\Permissions;

use Psr\Http\Message\ServerRequestInterface;

class EditPage extends AbstractUserPermissionsValidator
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_page';

    /**
     *
     */
    protected function getCapArgs(ServerRequestInterface $request): array
    {
        return [$request->getAttribute('post_id')];
    }
}
