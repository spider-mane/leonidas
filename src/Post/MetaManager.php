<?php

namespace WebTheory\Leonidas\Post;

use WebTheory\Leonidas\ObjectMetaManager;

class MetaManager extends ObjectMetaManager
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
