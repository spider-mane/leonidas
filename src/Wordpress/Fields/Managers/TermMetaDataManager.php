<?php

namespace WebTheory\WordPress\Fields\Managers;

use WebTheory\Form\Contracts\FieldDataManagerInterface;

class TermMetaDataManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'term';
    protected const ID_KEY = 'term_id';
    protected const NAME_KEY = 'name';
}
