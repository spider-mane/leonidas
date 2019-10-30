<?php

namespace WebTheory\Leonidas\Term;

use ObjectMetaManager;

class MetaManager extends ObjectMetaManager
{
    /**
     *
     */
    protected $objectType = 'term';

    /**
     *
     */
    public function __construct($metaKey)
    {
        $this->metaKey = $metaKey;
    }
}
