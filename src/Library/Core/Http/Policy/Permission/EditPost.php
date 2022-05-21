<?php

namespace Leonidas\Library\Core\Http\Policy\Permission;

class EditPost extends EditPage
{
    /**
     * {@inheritDoc}
     */
    protected $capability = 'edit_post';
}
