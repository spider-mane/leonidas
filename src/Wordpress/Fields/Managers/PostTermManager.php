<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;


/**
 *
 */
class PostTermManager extends AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     *
     */
    protected $taxonomy;

    /**
     *
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     *
     */
    public function getData($post)
    {
        return get_the_terms($post->id, $this->taxonomy, true);
    }

    /**
     *
     */
    public function saveData()
    {
        //
    }
}
