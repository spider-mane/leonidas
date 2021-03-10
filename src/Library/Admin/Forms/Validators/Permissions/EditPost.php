<?php

namespace Leonidas\Library\Admin\Forms\Validators\Permissions;

class EditPost extends EditPage
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_post';
}
