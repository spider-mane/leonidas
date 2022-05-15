<?php

namespace Leonidas\Library\Admin\Field\Data;

use Leonidas\Library\Admin\Field\Data\Abstracts\AbstractWPEntityMetaFieldDataManager;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;

class PostMetaFieldManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'post';
    protected const ID_KEY = 'ID';
    protected const NAME_KEY = 'post_name';
}
