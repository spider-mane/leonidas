<?php

namespace WebTheory\WordPress\Fields\Managers;

use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;

/**
 *
 */
class PostMetaFieldManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'post';
    protected const ID_KEY = 'ID';
    protected const NAME_KEY = 'post_name';
}
