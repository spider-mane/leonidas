<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Library\System\Schema\AbstractEntityMetaManager;

class PostMetaManager extends AbstractEntityMetaManager
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
