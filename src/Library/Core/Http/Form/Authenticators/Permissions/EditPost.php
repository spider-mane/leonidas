<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators\Permissions;

class EditPost extends EditPage
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_post';
}
