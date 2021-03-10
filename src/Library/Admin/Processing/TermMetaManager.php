<?php

namespace WebTheory\Leonidas\Library\Admin\Processing;

class TermMetaManager extends AbstractWpObjectMetaManager
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
