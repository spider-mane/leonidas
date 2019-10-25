<?php

namespace WebTheory\WordPress\Fields\Managers;

use WebTheory\Saveyour\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Saveyour\DataManagerFactory;
use WebTheory\WordPress\Fields\Managers\PostTermManager;
use WebTheory\WordPress\Fields\Managers\PostMetaFieldManager;
use WebTheory\WordPress\Fields\Managers\TermMetaDataManager;

class Factory extends DataManagerFactory implements MultiFieldDataManagerFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.wordpress' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const MANAGERS = [
        'post_meta' => PostMetaFieldManager::class,
        'term_meta' => TermMetaDataManager::class,
        'post_term' => PostTermManager::class,
    ] + parent::MANAGERS;
}
