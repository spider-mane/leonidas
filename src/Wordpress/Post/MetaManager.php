<?php

namespace WebTheory\WordPress\Post;

use ObjectMetaManager;

class MetaManager extends ObjectMetaManager
{
    /**
     *
     */
    protected $objectType = 'post';

    /**
     *
     */
    public function __construct($metaKey)
    {
        $this->metaKey = $metaKey;
    }
}
