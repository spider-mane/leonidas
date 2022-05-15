<?php

namespace Leonidas\Library\Admin\Field\Data;

use Leonidas\Library\Admin\Field\Data\Abstracts\AbstractWPEntityMetaFieldDataManager;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;

class TermMetaDataManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'term';
    protected const ID_KEY = 'term_id';
    protected const NAME_KEY = 'name';
}
