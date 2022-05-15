<?php

namespace Leonidas\Library\System\Schema\Term;

use Leonidas\Library\System\Schema\AbstractEntityMetaManager;

class TermMetaManager extends AbstractEntityMetaManager
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
