<?php

namespace WebTheory\Leonidas\Admin\Processing;

class PostMetaManager extends AbstractWpObjectMetaManager
{
    /**
     * {@inheritDoc}
     */
    protected const OBJECT_TYPE = 'post';

    /**
     * {@inheritDoc}
     */
    protected const GET_OBJECT_FUNCTION = 'get_post';

    /**
     * {@inheritDoc}
     */
    protected const OBJECT_ID_KEY = 'ID';
}
