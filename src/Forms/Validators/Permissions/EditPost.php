<?php

namespace WebTheory\Leonidas\Forms\Validators\Permissions;

class EditPost extends EditPage
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_post';
}
