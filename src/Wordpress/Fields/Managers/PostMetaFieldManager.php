<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Form\Contracts\FieldDataManagerInterface;

/**
 *
 */
class PostMetaFieldManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'post';
    protected const ID_KEY = 'ID';
    protected const NAME_KEY = 'post_name';
}
