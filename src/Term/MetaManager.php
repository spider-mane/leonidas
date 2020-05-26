<?php

namespace WebTheory\Leonidas\Term;

use WebTheory\Leonidas\ObjectMetaManager;

class MetaManager extends ObjectMetaManager
{
    /**
     * {@inheritDoc}
     */
    protected const OBJECT_TYPE = 'term';

    /**
     * {@inheritDoc}
     */
    protected const GET_OBJECT_FUNCTION = 'get_term';

    /**
     * {@inheritDoc}
     */
    protected const OBJECT_ID_KEY = 'term_id';
}
