<?php

namespace Leonidas\Library\Admin\Fields\Managers;

use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;

class PostMetaFieldManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'post';
    protected const ID_KEY = 'ID';
    protected const NAME_KEY = 'post_name';
}
