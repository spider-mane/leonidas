<?php

namespace WebTheory\Leonidas\Admin\Term;

use WebTheory\Leonidas\Admin\AbstractWpObjectMetaManager;

class MetaManager extends AbstractWpObjectMetaManager
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
